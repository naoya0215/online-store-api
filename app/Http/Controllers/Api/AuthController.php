<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\AdminResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\Admin;

class AuthController extends Controller
{
    public function login(LoginRequest $request) :JsonResponse
    {
        Log::info('API Request:', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'admin_agent' => $request->userAgent(),
            'body' => $request->all(),
            'headers' => $request->headers->all(),
        ]);
        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials)) {
            // 認証
            $admin = Auth::user();
            // トークン生成
            $token = $admin->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'ログイン成功',
                'admin' => new AdminResource($admin),
                'token' => $token,
            ], 200);
        }
        
        return response()->json([
            'success' => false,
            'message' => LoginRequest::AUTH_FAILED_MESSAGE,
        ], 401);
    }

    public function logout(Request $request) :JsonResponse
    {
        $request->admin()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'ログアウトしました',
        ]);
    }

    /**
     * 現在ログイン中のユーザー情報取得
     */
    public function admin(Request $request) :JsonResponse
    {
        return response()->json([
            'success' => true,
            'admin' => $request->admin(),
        ]);
    }
}