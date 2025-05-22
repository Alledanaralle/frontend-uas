<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; // Tambahin ini

Route::get("/", [UserController::class, "index"])->name("dashboard");
Route::put("/users/", [UserController::class, "update"])->name("users.update"); // Tambahkan baris ini
Route::delete("/users/{id}", [UserController::class, "destroy"])->name(
    "users.destroy"
);
Route::post("/users", [UserController::class, "store"])->name("users.store");
