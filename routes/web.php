<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return response()->json([
        'message' => '認証されていません。/api/login からログインしてください。'
    ], 401);
})->name('login');