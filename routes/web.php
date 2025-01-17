<?php

use App\Http\Controllers\EmployeeController;

Route::get('/', [EmployeeController::class, 'index']); // Index page

Route::prefix('employees')->group(function () {
    Route::get('/{id}', [EmployeeController::class, 'show']);  // Menampilkan employee berdasarkan ID
    Route::post('/', [EmployeeController::class, 'store']);  // Menambah employee
    Route::put('/{id}', [EmployeeController::class, 'update']);  // Mengupdate employee
    Route::delete('/{id}', [EmployeeController::class, 'destroy']);  // Menghapus employee
    Route::get('/positions', [EmployeeController::class, 'positions']);  // Menampilkan posisi
});
