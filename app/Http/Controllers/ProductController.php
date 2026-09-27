<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $products = Product::withCount(['licenses as available_license_count' => function ($q) {
            $q->whereNull('user_id');
        }])->get();

        return ProductResource::collection($products);
    }
}
