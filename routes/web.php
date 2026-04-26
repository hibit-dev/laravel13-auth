<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', [App\Http\Controllers\LoginController::class, 'login'])->name('login');
Route::get('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

Route::get('/public', function () {
    return 'This is a public page, anyone can see it.';
});

Route::middleware(['auth:custom'])->group(function () {
    Route::get('/private', function () {
        return 'This is a private page, only authenticated users can see it.';
    });
});
