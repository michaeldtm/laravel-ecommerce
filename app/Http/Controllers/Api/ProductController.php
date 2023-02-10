<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

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
        /** @var User $user */
        $user = $request->user();

        DB::transaction(function () use ($request, $user) {
            /** @var Product $product */
            $product = $user->products()->save(
                new Product([...$request->validated()])
            );

            $product->categories()->sync($request->get('categories'));

            return $product;
        });

        return response()->json([
            'message' => __('messages.product.created')
        ]);
    }
}
