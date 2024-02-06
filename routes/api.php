<?php

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/login', App\Domain\Customer\Api\Auth\Login::class);
    });
});

Route::middleware('user:api-customer')->group(function () {
    Route::post('/auth/logout', App\Domain\Customer\Api\Auth\Logout::class);
});
