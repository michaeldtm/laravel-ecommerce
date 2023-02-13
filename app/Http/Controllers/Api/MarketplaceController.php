<?php

namespace App\Http\Controllers\Api;

use App\Filters\ProductCategoryFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class MarketplaceController extends Controller
{
    public function __invoke(): AnonymousResourceCollection
    {
        $products = QueryBuilder::for(Product::class)
            ->allowedIncludes(['categories', 'features'])
            ->allowedFilters(['name', 'description', AllowedFilter::custom('cat', new ProductCategoryFilter)])
            ->allowedSorts(['name', 'price'])
            ->defaultSort('price')
            ->simplePaginate(25);

        return ProductResource::collection($products);
    }
}
