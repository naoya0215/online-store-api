<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\SettingsController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/admin', [AuthController::class, 'admin']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('admin')->group(function () {
        // 商品管理
        Route::get('products', [ProductController::class, 'index']);
        Route::get('products/create', [ProductController::class, 'create']);
        Route::post('products', [ProductController::class, 'store']);
        Route::get('products/{id}/edit', [ProductController::class, 'edit']);
        Route::put('products/{id}', [ProductController::class, 'update']);
        Route::delete('products/{id}', [ProductController::class, 'destroy']);
        Route::get('categories', [ProductController::class, 'getCategories']);

        // 問い合わせ管理
        Route::get('/contacts', [ContactController::class, 'index']);
        Route::get('/contacts/{id}', [ContactController::class, 'show']);
        Route::delete('/contacts/{id}', [ContactController::class, 'destroy']);

        // 注文管理
        Route::get('orders', [OrderController::class, 'index']);
        Route::get('orders/{id}', [OrderController::class, 'show']);
        Route::delete('orders/{id}', [OrderController::class, 'destroy']);

        // 設定
        Route::get('profile', [SettingsController::class, 'getProfile']);
        Route::put('profile', [SettingsController::class, 'updateProfile']);
        Route::put('password', [SettingsController::class, 'updatePassword']);
    });
});

// 画像配信API（認証不要 - パブリックアクセス）
Route::get('/images/products/{filename}', function ($filename) {
    $path = storage_path('app/public/products/' . $filename);
    
    if (!file_exists($path)) {
        abort(404, 'Image not found');
    }
    
    $mimeType = mime_content_type($path);
    
    return response()->file($path, [
        'Content-Type' => $mimeType,
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'GET',
        'Access-Control-Allow-Headers' => 'Content-Type'
    ]);
})->where('filename', '.*');