# Simon Kehadiran (Frontend)

Sebuah antarmuka pengguna (frontend) berbasis web yang dibangun dengan Laravel untuk aplikasi Simon Kehadiran. Aplikasi ini terhubung ke backend API (saat ini menggunakan CodeIgniter) untuk mengelola data user.

## Cara Menjalankan Project (Instalasi)

Berikut adalah langkah-langkah untuk menjalankan project frontend ini dari awal (instalasi Laravel):

1.  **Pastikan PHP dan Composer Terinstall**

    Sebelum memulai, pastikan komputer kamu sudah terinstall PHP (minimal versi 8.1) dan Composer (dependency manager untuk PHP). Kamu bisa cek versinya dengan perintah berikut di terminal:

    ```bash
    php -v
    composer --version
    ```

    Jika belum terinstall, silakan unduh dan install dari website resminya ([PHP](https://www.php.net/downloads.php), [Composer](https://getcomposer.org/download/)).

2.  **Install Laravel**

    Buka terminal kamu, masuk ke direktori tempat kamu ingin menyimpan project ini, lalu jalankan perintah berikut untuk membuat project Laravel baru:

    ```bash
    composer create-project laravel/laravel simon-kehadiran-frontend
    cd simon-kehadiran-frontend
    ```

    Ganti `simon-kehadiran-frontend` dengan nama project yang kamu inginkan.

3.  **Konfigurasi Koneksi Database**

    Meskipun frontend ini fokus pada tampilan dan berinteraksi dengan API, Laravel secara default memerlukan konfigurasi database. Kamu bisa menggunakan database dummy seperti SQLite agar tidak perlu setup database sungguhan.

    Buka file `.env` dan konfigurasi detail database kamu. Contoh untuk SQLite:

    ```dotenv
    DB_CONNECTION=sqlite
    DB_DATABASE=database.sqlite
    ```

    Jika kamu menggunakan database lain seperti MySQL atau PostgreSQL, sesuaikan konfigurasinya di file `.env`. Jangan lupa untuk menjalankan migrasi (meskipun mungkin tidak terlalu relevan untuk frontend murni ini):

    ```bash
    php artisan migrate
    ```

4.  **Menjalankan Development Server**

    Untuk menjalankan project Laravel frontend, gunakan perintah berikut di terminal (dari direktori project):

    ```bash
    php artisan serve
    ```

    Ini akan menjalankan development server di `http://127.0.0.1:8000`. Buka alamat ini di browser kamu.

## Menghubungkan ke Backend API (CodeIgniter)

Frontend ini berkomunikasi dengan backend API (yang dalam kasus ini kamu buat dengan CodeIgniter) melalui HTTP request. Konfigurasi dasar untuk terhubung ke backend (misalnya, URL base API) biasanya diletakkan di file `.env` atau langsung di dalam kode controller/service yang melakukan panggilan API.

Contoh penggunaan `Http` facade di controller Laravel untuk mengambil data dari backend:


```use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function index()
    {
        $response = Http::get(env('BACKEND_API_URL') . '/user');
        $users = $response->json();
        return view('user.index', compact('users'));
    }
}
