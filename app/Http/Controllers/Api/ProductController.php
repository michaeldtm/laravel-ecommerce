<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $products = Product::forUser(request()->user())
            ->with('categories')
            ->simplePaginate();

        return ProductResource::collection($products);
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $user = $request->user();

        $product = $user->products()->save(
            new Product([...$request->validated()])
        );

        $product->categories()->sync(
            $request->get('categories')
        );

        return response()->json([
            'message' => __('messages.product.created')
        ]);
    }
}
