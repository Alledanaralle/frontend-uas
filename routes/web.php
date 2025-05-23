<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; // Tambahin ini

Route::get("/", [UserController::class, "index"])->name("dashboard");
Route::get("/matkul", [UserController::class, "index_matkul"])->name(
    "dashboard_matkul"
);
Route::put("/users/", [UserController::class, "update"])->name("users.update"); // Tambahkan baris ini
Route::delete("/users/{id}", [UserController::class, "destroy"])->name(
    "users.destroy"
);
Route::post("/users", [UserController::class, "store"])->name("users.store");

Route::put("/matkul/update", [UserController::class, "update_matkul"])->name(
    "matkul.update"
); // Tambahkan baris ini
Route::delete("/matkul/delete/{id}", [
    UserController::class,
    "destroy_matkul",
])->name("matkul.destroy");
Route::post("/matkul/add", [UserController::class, "store_matkul"])->name(
    "matkul.store"
);
