<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SearchProductService;

class CategoryController extends Controller
{
    /**
     * Get products based on category.
     */
    public function __invoke(Request $request, string $section, string $category): object
    {
        $request->merge(['slug' => $category]);

        if (SubCategory::where('slug', $category)->exists()) {
            return SearchProductService::searchProductQuery($request, 'subCategories');
        }

        // Then check category
        if (Category::where('slug', $category)->exists()) {
            return SearchProductService::searchProductQuery($request, 'categories');
        }

        // If neither exists, return an empty response or handle the error as needed
        return response()->json(['message' => 'No products found for this category'], 404);
    }
}
