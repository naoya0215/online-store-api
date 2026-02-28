<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class LoginRequest extends FormRequest
{
    const AUTH_FAILED_MESSAGE = 'メールアドレスまたはパスワードが正しくありません。';
    const VALIDATION_FAILED_MESSAGE = '入力内容に誤りがあります。';

    /**
     * リクエストが許可されているかを判定
     */
    public function authorize(): bool
    {
        return true; // 誰でもログイン試行可能
    }

    /**
     * バリデーションルール
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6|max:255',
        ];
    }

    /**
     * カスタムエラーメッセージ
     */
    public function messages(): array
    {
        return [
            'email.required' => 'メールアドレスは必須です。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'email.max' => 'メールアドレスは255文字以内で入力してください。',
            'password.required' => 'パスワードは必須です。',
            'password.min' => 'パスワードは6文字以上で入力してください。',
            'password.max' => 'パスワードは255文字以内で入力してください。',
        ];
    }

    /**
     * バリデーション対象の属性名をカスタマイズ
     */
    public function attributes(): array
    {
        return [
            'email' => 'メールアドレス',
            'password' => 'パスワード',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => self::VALIDATION_FAILED_MESSAGE,
                'errors' => $validator->errors()
            ], 422)
        );
    }
}