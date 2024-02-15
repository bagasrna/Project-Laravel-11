<?php

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/login', App\Domain\Customer\Api\Auth\Login::class);
        Route::get('/facebook', App\Domain\Customer\Api\Auth\LoginFacebook::class);
        Route::post('/facebook/callback', App\Domain\Customer\Api\Auth\LoginFacebookCallback::class);
    });
});

Route::middleware('user:api-customer')->group(function () {
    Route::post('/auth/logout', App\Domain\Customer\Api\Auth\Logout::class);
});