<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     *  商品一覧
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $result = $this->productService->getProducts($request);
            
            return response()->json([
                'success' => true,
                ...$result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '商品データの取得に失敗しました',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     *  商品登録
     */
    public function create()
    {
        try {
            $result = $this->productService->getCategories();
            
            return response()->json([
                'success' => true,
                ...$result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'カテゴリデータの取得に失敗しました',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     *  商品保存
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $imageFile = $request->hasFile('image') ? $request->file('image') : null;

            $this->productService->createProduct($data, $imageFile);
            
            return response()->json([
                'success' => true,
                'message' => '商品が正常に作成されました'
            ], 201);
        } catch (\Exception $e) { 
            return response()->json([
                'success' => false,
                'message' => '商品の作成に失敗しました',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     *  商品編集
     */
    public function edit(Request $request, string $id): JsonResponse
    {
        try {
            $productId = (int) $id;
            
            // 商品データを取得
            $product = $this->productService->getProduct($productId);
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => '商品が見つかりません'
                ], 404);
            }
            
            // カテゴリデータを取得
            $result = $this->productService->getCategories();
            
            return response()->json([
                'success' => true,
                'product' => $product,
                ...$result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '商品データの取得に失敗しました',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     *  商品更新
     */
    public function update(UpdateProductRequest $request, string $id): JsonResponse
    {
        try {
            $productId = (int) $id;
            
            // 商品の存在確認
            $product = $this->productService->getProduct($productId);
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => '商品が見つかりません'
                ], 404);
            }
            
            $data = $request->validated();
            $imageFile = $request->hasFile('image') ? $request->file('image') : null;

            $this->productService->updateProduct($productId, $data, $imageFile);
            
            return response()->json([
                'success' => true,
                'message' => '商品が正常に更新されました'
            ]);
        } catch (\Exception $e) { 
            return response()->json([
                'success' => false,
                'message' => '商品の更新に失敗しました',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     *  商品削除
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $productId = (int) $id;
            
            // 商品の存在確認
            $product = $this->productService->getProduct($productId);
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => '商品が見つかりません'
                ], 404);
            }
            
            $this->productService->deleteProduct($productId);
            
            return response()->json([
                'success' => true,
                'message' => '商品が正常に削除されました'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '商品の削除に失敗しました',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * カテゴリー取得
     */
    public function getCategories(): JsonResponse
    {
        try {
            $result = $this->productService->getCategories();
            
            return response()->json([
                'success' => true,
                ...$result
            ]);
        } catch (\Exception $e) { 
            return response()->json([
                'success' => false,
                'message' => 'カテゴリーデータの取得に失敗しました',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
