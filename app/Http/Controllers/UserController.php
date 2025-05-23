<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
// Pastikan ini sudah ada

class UserController extends Controller
{
    /**
     * Menampilkan daftar user dari backend CodeIgniter.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        try {
            // Mengambil data user dari backend CodeIgniter
            // Menambahkan orderBy("id_user", "asc") di backend CodeIgniter untuk pengurutan
            $response = Http::get("http://localhost:8080/user");

            // Memeriksa apakah request berhasil
            if ($response->successful()) {
                $users = collect($response->json())
                    ->sortBy("id_user")
                    ->values();
            } else {
                $users = []; // Jika gagal, set array kosong
                // Log error atau tampilkan pesan ke user
                session()->flash(
                    "error",
                    "Gagal mengambil data dari backend. Pastikan backend kamu jalan yaa."
                );
            }

            // Mengirim data user ke view welcome.blade.php
            return view("welcome", compact("users"));
        } catch (\Exception $e) {
            // Menangkap exception jika ada masalah koneksi ke backend
            $users = [];
            session()->flash(
                "error",
                "Terjadi kesalahan saat menghubungi backend: " .
                    $e->getMessage()
            );
            return view("welcome", compact("users"));
        }
    }

    public function index_matkul()
    {
        try {
            // Mengambil data user dari backend CodeIgniter
            // Menambahkan orderBy("id_user", "asc") di backend CodeIgniter untuk pengurutan
            $response = Http::get("http://localhost:8080/matkul");

            // Memeriksa apakah request berhasil
            if ($response->successful()) {
                $matkul = collect($response->json())
                    ->sortBy("kode_matkul")
                    ->values();
            } else {
                $matkul = []; // Jika gagal, set array kosong
                // Log error atau tampilkan pesan ke user
                session()->flash(
                    "error",
                    "Gagal mengambil data dari backend. Pastikan backend kamu jalan yaa."
                );
            }

            // Mengirim data user ke view welcome.blade.php
            return view("matkul", compact("matkul"));
        } catch (\Exception $e) {
            // Menangkap exception jika ada masalah koneksi ke backend
            $matkul = [];
            session()->flash(
                "error",
                "Terjadi kesalahan saat menghubungi backend: " .
                    $e->getMessage()
            );
            return view("matkul", compact("matkul"));
        }
    }

    /**
     * Mengupdate data user melalui backend CodeIgniter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Mengambil data dari form modal
        $id_user = $request->input("id_user");
        $username = $request->input("username");
        $password = $request->input("password");
        $level = $request->input("level");

        // Data yang akan dikirim ke backend CodeIgniter
        $dataToUpdate = [
            "username" => $username,
            "level" => $level,
        ];

        // Hanya tambahkan password jika diisi di form
        if (!empty($password)) {
            $dataToUpdate["password"] = $password;
        }

        try {
            // Mengirim request PUT ke backend CodeIgniter
            $response = Http::asForm()->put(
                "http://localhost:8080/user/{$id_user}",
                $dataToUpdate
            );

            // Memeriksa apakah update berhasil di backend
            if ($response->successful()) {
                return redirect()
                    ->route("dashboard")
                    ->with("success", "Data user berhasil diupdate!");
            } else {
                // Jika backend mengembalikan error
                $errorMessage =
                    $response->json()["messages"]["error"] ??
                    "Gagal mengupdate data user di backend.";
                return redirect()
                    ->route("dashboard")
                    ->with("error", $errorMessage);
            }
        } catch (\Exception $e) {
            // Menangkap exception jika ada masalah koneksi ke backend
            return redirect()
                ->route("dashboard")
                ->with(
                    "error",
                    "Terjadi kesalahan saat menghubungi backend: " .
                        $e->getMessage()
                );
        }
    }

    /**
     * Mengupdate data user melalui backend CodeIgniter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update_matkul(Request $request)
    {
        // Mengambil data dari form modal
        $kode_matkul = $request->input("kode_matkul");
        $namaMatkul = $request->input("nama_matkul");
        $sks = $request->input("sks");

        // Data yang akan dikirim ke backend CodeIgniter
        $dataToUpdate = [
            "nama_matkul" => $namaMatkul,
            "sks" => $sks,
        ];

        try {
            // Mengirim request PUT ke backend CodeIgniter
            $response = Http::put(
                "http://localhost:8080/matkul/{$kode_matkul}",
                $dataToUpdate
            );

            // Memeriksa apakah update berhasil di backend
            if ($response->successful()) {
                return redirect()
                    ->route("dashboard_matkul")
                    ->with("success", "Data matkul berhasil diupdate!");
            } else {
                // Jika backend mengembalikan error
                $errorMessage =
                    $response->json()["messages"]["error"] ??
                    "Gagal mengupdate data matkul di backend.";
                return redirect()
                    ->route("dashboard_matkul")
                    ->with("error", $errorMessage);
            }
        } catch (\Exception $e) {
            // Menangkap exception jika ada masalah koneksi ke backend
            return redirect()
                ->route("dashboard_matkul")
                ->with(
                    "error",
                    "Terjadi kesalahan saat menghubungi backend: " .
                        $e->getMessage()
                );
        }
    }

    /**
     * Menghapus data user melalui backend CodeIgniter.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $response = Http::delete("http://localhost:8080/user/{$id}");

            if ($response->successful()) {
                return redirect()
                    ->route("dashboard")
                    ->with("success", "Data user berhasil dihapus!");
            } else {
                $errorMessage =
                    $response->json()["messages"]["error"] ??
                    "Gagal menghapus data matkul di backend.";
                return redirect()
                    ->route("dashboard")
                    ->with("error", $errorMessage);
            }
        } catch (\Exception $e) {
            return redirect()
                ->route("dashboard")
                ->with(
                    "error",
                    "Terjadi kesalahan saat menghubungi backend: " .
                        $e->getMessage()
                );
        }
    }

    /**
     * Menghapus data user melalui backend CodeIgniter.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy_matkul($id)
    {
        try {
            $response = Http::delete("http://localhost:8080/matkul/{$id}");

            if ($response->successful()) {
                return redirect()
                    ->route("dashboard_matkul")
                    ->with("success", "Data matkul berhasil dihapus!");
            } else {
                $errorMessage =
                    $response->json()["messages"]["error"] ??
                    "Gagal menghapus data matkul di backend.";
                return redirect()
                    ->route("dashboard_matkul")
                    ->with("error", $errorMessage);
            }
        } catch (\Exception $e) {
            return redirect()
                ->route("dashboard_matkul")
                ->with(
                    "error",
                    "Terjadi kesalahan saat menghubungi backend: " .
                        $e->getMessage()
                );
        }
    }

    /**
     * Menyimpan data user baru melalui backend CodeIgniter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $username = $request->input("username");
        $password = $request->input("password");
        $level = $request->input("level");

        $dataToSend = [
            "username" => $username,
            "password" => $password,
            "level" => $level,
        ];

        try {
            $response = Http::asForm()->post(
                "http://localhost:8080/user",
                $dataToSend
            );

            if ($response->successful()) {
                return redirect()
                    ->route("dashboard")
                    ->with("success", "Data user berhasil ditambahkan!");
            } else {
                $errorMessage =
                    $response->json()["messages"]["error"] ??
                    "Gagal menambahkan data user di backend.";
                return redirect()
                    ->route("dashboard")
                    ->with("error", $errorMessage);
            }
        } catch (\Exception $e) {
            return redirect()
                ->route("dashboard")
                ->with(
                    "error",
                    "Terjadi kesalahan saat menghubungi backend: " .
                        $e->getMessage()
                );
        }
    }

    /**
     * Menyimpan data user baru melalui backend CodeIgniter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store_matkul(Request $request)
    {
        $kodeMatkul = $request->input("kode_matkul");
        $namaMatkul = $request->input("nama_matkul");
        $sks = $request->input("sks");

        $dataToSend = [
            "kode_matkul" => $kodeMatkul,
            "nama_matkul" => $namaMatkul,
            "sks" => $sks,
        ];

        try {
            $response = Http::asForm()->post(
                "http://localhost:8080/matkul",
                $dataToSend
            );

            if ($response->successful()) {
                return redirect()
                    ->route("dashboard_matkul")
                    ->with("success", "Data matkul berhasil ditambahkan!");
            } else {
                $errorMessage =
                    $response->json()["messages"]["error"] ??
                    "Gagal menambahkan data matkul di backend.";
                return redirect()
                    ->route("dashboard_matkul")
                    ->with("error", $errorMessage);
            }
        } catch (\Exception $e) {
            return redirect()
                ->route("dashboard_matkul")
                ->with(
                    "error",
                    "Terjadi kesalahan saat menghubungi backend: " .
                        $e->getMessage()
                );
        }
    }
}
