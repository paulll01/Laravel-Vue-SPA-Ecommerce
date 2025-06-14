<?php

namespace App\Http\Controllers\Api;

use DB;
use App\Models\Product;
use App\Models\ProductView;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\relatedProductService;
use App\Http\Resources\Api\Frontend\ProductResource;
use App\Http\Resources\Api\Frontend\FullProductResource;

class ProductController extends Controller
{

    /**
     * Get specific product details by product slug.
     */
    public function index(Request $request): JsonResponse
    {
        $product = Product::select('id', 'name', 'image', 'slug', 'description', 'specification', 'sale_price', 'category_id', 'gallery', 'offer_id')
            ->where('slug', $request->slug)
            ->withCount('review')
            ->withAvg('review', 'rating_value')
            ->with([
                'offer:id,discount,type,start_date,expire_date,status',
                'review' => function ($query) {
                    $query->take(10)->with('user:id,name');
                }
            ])
            ->first();

        $relatedProducts = relatedProductService::relatedProductQuery($product->category_id);

        return response()->json([
            'product' => new FullProductResource($product),
            'relatedProducts' => ProductResource::collection($relatedProducts)
        ]);
    }

    /**
     * When a product is visited it will be updated or created in the database.
     */
    public function productViewCount(Request $request): void
    {
        ProductView::updateOrCreate(['product_id' => $request->id], ['view_count' => DB::raw('view_count+' . 1)]);
    }
}
