<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SearchProductService;

class SectionController extends Controller
{
    /**
     * Get products based on category.
     */
    public function __invoke(Request $request, string $section): object
    {
        $request->merge(['slug' => $section]);

        return SearchProductService::searchProductQuery($request, 'sections');
    }
}
