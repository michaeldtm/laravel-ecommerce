<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductFeature;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $products = Product::forUser(request()->user())
            ->with(['categories', 'features'])
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

            $features = [];
            foreach ($request->get('features') as $feature) {
                $model = new ProductFeature;
                $features[] = $model->fill(['description' => $feature]);
            }
            $product->features()->saveMany($features);

            return $product;
        });

        return response()->json([
            'message' => __('messages.product.created')
        ]);
    }

    public function show(Product $product): ProductResource
    {
        $product = $product->load(['categories', 'features']);
        return ProductResource::make($product);
    }

    public function update(ProductRequest $request, Product $product): JsonResponse
    {
        DB::transaction(function () use ($request, $product) {
            $product->update($request->validated());

            $product->categories()->sync($request->get('categories'));

            $product->features()->delete();
            $features = [];
            foreach ($request->get('features') as $feature) {
                $model = new ProductFeature;
                $features[] = $model->fill(['description' => $feature]);
            }
            $product->features()->saveMany($features);

            return $product;
        });

        return response()->json([
            'message' => __('messages.product.updated'),
        ]);
    }
}
