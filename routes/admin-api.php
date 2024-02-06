<?php

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/login', App\Domain\Admin\Api\Auth\Login::class);
    });
});

Route::middleware('user:api-admin')->group(function () {
    Route::post('/auth/logout', App\Domain\Admin\Api\Auth\Logout::class);
});
