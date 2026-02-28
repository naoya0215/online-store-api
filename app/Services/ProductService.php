<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    /**
     * 商品一覧を取得
     */
    public function getProducts($request): array
    {
        $query = DB::table('products as p')
            ->leftJoin('categories as c', 'p.category_id', '=', 'c.id')
            ->leftJoin('stocks as s', 'p.id', '=', 's.product_id')
            ->leftJoin('admins as a', 'p.admin_id', '=', 'a.id')
            ->select([
                'p.id',
                'p.admin_id',
                'p.category_id',
                'p.name',
                'p.price',
                'p.description',
                'p.image_path',
                'p.display_order',
                'p.is_selling',
                'p.is_deleted',
                'p.created_at',
                'p.updated_at',
                'c.name as category_name',
                'a.name as admin_name',
                's.quantity as stock_quantity',
                's.low_stock_threshold'
            ])
            ->where('p.is_deleted', false);
        
        $this->applySearchFilters($query, $request);

        // ソート処理
        $sortBy = $request->get('sort_by', 'display_order');
        $sortOrder = $request->get('sort_order', 'asc');

        // 許可されたソートカラムのみ
        $allowedSortColumns = ['name', 'price', 'stock_quantity', 'updated_at', 'display_order'];
        if (in_array($sortBy, $allowedSortColumns)) {
            if ($sortBy === 'stock_quantity') {
                $query->orderBy('s.quantity', $sortOrder);
            } else {
                $query->orderBy('p.' . $sortBy, $sortOrder);
            }
        } else {
            $query->orderBy('p.display_order', 'asc');
        }

        // ページネーション
        $perPage = $request->get('per_page', 10);
        $perPage = min(max($perPage, 1), 100);

        $page = $request->get('page', 1);
        $total = $query->count();

        $products = $query
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        // 画像URLの変換
        $products = $products->map(function ($product) {
            $product->image_path = $this->getImageUrl($product->image_path);
            return $product;
        });

        // ページネーション情報
        $pagination = [
            'current_page' => (int) $page,
            'per_page' => (int) $perPage,
            'total' => $total,
            'last_page' => (int) ceil($total / $perPage),
            'from' => $total > 0 ? ($page - 1) * $perPage + 1 : 0,
            'to' => min($page * $perPage, $total),
        ];

        return [
            'products' => $products,
            'pagination' => $pagination,
        ];
    }

    /**
     * 検索フィルターを適用
     */
    private function applySearchFilters($query, $request): void
    {
        // 商品名での検索
        if ($request->filled('name')) {
            $query->where('p.name', 'like', '%' . $request->get('name') . '%');
        }

        // カテゴリーでの絞り込み
        if ($request->filled('category_id')) {
            $query->where('p.category_id', $request->get('category_id'));
        }

        // 価格範囲での絞り込み
        if ($request->filled('min_price')) {
            $query->where('p.price', '>=', $request->get('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('p.price', '<=', $request->get('max_price'));
        }

        // 在庫数での絞り込み
        if ($request->filled('min_stock')) {
            $query->where('s.quantity', '>=', $request->get('min_stock'));
        }
        if ($request->filled('max_stock')) {
            $query->where('s.quantity', '<=', $request->get('max_stock'));
        }

        // 販売状況での絞り込み
        if ($request->has('is_selling') && $request->get('is_selling') !== '') {
            $query->where('p.is_selling', $request->boolean('is_selling'));
        }
    }

    /**
     * 商品詳細を取得
     */
    public function getProduct(int $id): ?object
    {
        $product = DB::table('products as p')
            ->leftJoin('categories as c', 'p.category_id', '=', 'c.id')
            ->leftJoin('stocks as s', 'p.id', '=', 's.product_id')
            ->leftJoin('admins as a', 'p.admin_id', '=', 'a.id')
            ->select([
                'p.id',
                'p.admin_id',
                'p.category_id',
                'p.name',
                'p.price',
                'p.description',
                'p.image_path',
                'p.display_order',
                'p.is_selling',
                'p.is_deleted',
                'p.created_at',
                'p.updated_at',
                'c.name as category_name',
                'a.name as admin_name',
                's.quantity as stock_quantity',
                's.low_stock_threshold'
            ])
            ->where('p.id', $id)
            ->where('p.is_deleted', false)
            ->first();

        if ($product) {
            $product->image_path = $this->getImageUrl($product->image_path);
        }

        return $product;
    }

    /**
     * カテゴリーを取得
     */
    public function getCategories()
    {
        $categories = DB::table('categories')
            ->select('id', 'name', 'display_order')
            ->orderBy('display_order', 'asc')
            ->get();

        return [
            'categories' => $categories,
        ]; 
    }

    /**
     * 商品保存
     */
    public function createProduct(array $data, UploadedFile $imageFile = null): bool
    {
        return DB::transaction(function () use ($data, $imageFile) {
            // 画像ファイルの処理
            $imagePath = null;
            if ($imageFile && $imageFile instanceof UploadedFile) {
                $imagePath = $this->saveProductImage($imageFile);
            }

            // 表示順序を取得（最大値+1）
            $maxDisplayOrder = DB::table('products')->max('display_order') ?? 0;

            // 商品データを挿入
            $productId = DB::table('products')->insertGetId([
                'admin_id' => auth()->id(),
                'category_id' => $data['category_id'],
                'name' => $data['name'],
                'price' => $data['price'],
                'description' => $data['description'],
                'image_path' => $imagePath,
                'display_order' => $maxDisplayOrder + 1,
                'is_deleted' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 在庫データを挿入
            DB::table('stocks')->insert([
                'product_id' => $productId,
                'quantity' => $data['stock_quantity'],
                'low_stock_threshold' => $data['low_stock_threshold'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return true;
        });
    }

    /**
     * 商品更新
     */
    public function updateProduct(int $id, array $data, UploadedFile $imageFile = null): bool
    {
        return DB::transaction(function () use ($id, $data, $imageFile) {
            // 現在の商品データを取得
            $currentProduct = DB::table('products')->where('id', $id)->first();
            if (!$currentProduct) {
                throw new \Exception('商品が見つかりません');
            }

            // 画像ファイルの処理
            $imagePath = $currentProduct->image_path;
            if ($imageFile && $imageFile instanceof UploadedFile) {
                // 新しい画像を保存
                $newImagePath = $this->saveProductImage($imageFile);
                
                // 古い画像を削除（URLでない場合のみ）
                if ($imagePath && !str_starts_with($imagePath, 'http')) {
                    Storage::disk('public')->delete($imagePath);
                }
                
                $imagePath = $newImagePath;
            }

            // 商品データを更新
            DB::table('products')
                ->where('id', $id)
                ->update([
                    'category_id' => $data['category_id'],
                    'name' => $data['name'],
                    'price' => $data['price'],
                    'description' => $data['description'],
                    'image_path' => $imagePath,
                    'is_selling' => $data['is_selling'] ?? false,
                    'updated_at' => now(),
                ]);

            // 在庫データを更新
            DB::table('stocks')
                ->where('product_id', $id)
                ->update([
                    'quantity' => $data['stock_quantity'],
                    'low_stock_threshold' => $data['low_stock_threshold'],
                    'updated_at' => now(),
                ]);

            return true;
        });
    }

    /**
     * 商品削除（論理削除）
     */
    public function deleteProduct(int $id): bool
    {
        return DB::table('products')
            ->where('id', $id)
            ->update([
                'is_deleted' => true,
                'updated_at' => now(),
            ]);
    }

    /**
     * 商品画像を保存
     */
    private function saveProductImage(\Illuminate\Http\UploadedFile $file): string
    {
        // productsディレクトリが存在しない場合は作成
        $productsDir = storage_path('app/public/products');
        if (!is_dir($productsDir)) {
            mkdir($productsDir, 0755, true);
        }

        // ファイル名を生成（UUID + 元の拡張子）
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        
        // publicディスクのproducts フォルダに保存
        $path = $file->storeAs('products', $fileName, 'public');

        // ファイルが実際に保存されたか確認
        $fullPath = storage_path('app/public/' . $path);
        \Log::info('File exists check:', [
            'full_path' => $fullPath,
            'exists' => file_exists($fullPath)
        ]);
        
        // 保存されたパスを返す
        return $path;
    }

    private function getImageUrl(?string $imagePath): ?string
    {
        if (!$imagePath) {
            return null;
        }

        if (str_starts_with($imagePath, 'http://') || str_starts_with($imagePath, 'https://')) {
            return $imagePath;
        }

        // 相対パスの場合は完全なURLに変換
        return Storage::disk('public')->url($imagePath);
    }
}
