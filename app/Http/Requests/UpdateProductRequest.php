<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string', 'max:1000'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'low_stock_threshold' => ['required', 'integer', 'min:0'],
            'is_selling' => ['required', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], 
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => '商品名は必須です。',
            'name.max' => '商品名は255文字以内で入力してください。',
            'category_id.required' => 'カテゴリーは必須です。',
            'category_id.exists' => '選択されたカテゴリーが存在しません。',
            'price.required' => '価格は必須です。',
            'price.numeric' => '価格は数値で入力してください。',
            'price.min' => '価格は0以上で入力してください。',
            'description.required' => '商品説明は必須です。',
            'description.max' => '商品説明は1000文字以内で入力してください。',
            'stock_quantity.required' => '在庫数は必須です。',
            'stock_quantity.integer' => '在庫数は整数で入力してください。',
            'stock_quantity.min' => '在庫数は0以上で入力してください。',
            'low_stock_threshold.required' => '在庫警告閾値は必須です。',
            'low_stock_threshold.integer' => '在庫警告閾値は整数で入力してください。',
            'low_stock_threshold.min' => '在庫警告閾値は0以上で入力してください。',
            'is_selling.required' => '販売状態は必須です。',
            'is_selling.boolean' => '販売状態は有効な値である必要があります。',
            'image.image' => 'アップロードされたファイルは画像である必要があります。',
            'image.mimes' => '画像はjpeg、png、jpg、gif形式のみ対応しています。',
            'image.max' => '画像サイズは2MB以下にしてください。',
        ];
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'message' => 'バリデーションエラーが発生しました。',
            'errors' => $validator->errors()->toArray()
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}