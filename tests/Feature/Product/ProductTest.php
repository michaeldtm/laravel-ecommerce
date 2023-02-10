<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

it('get paginated products for authenticated user', function () {
    $user = User::factory()
        ->has(Product::factory()->count(20))
        ->create();

    $product = $user->products->first();

    User::factory()->has(
        Product::factory()
            ->has(Category::factory()->count(2))
            ->count(5)
    )->create();

    loginAsUser($user);

    $this->getJson(route('products.index'))
        ->assertOk()
        ->assertJson(fn (AssertableJson $json) => $json
            ->has('data', 15)
            ->has('data.0', fn ($json) => $json
                ->where('id', $product->id)
                ->where('name', $product->name)
                ->where('description', $product->description)
                ->where('price', $product->price)
                ->where('categories', $product->categories)
                ->missing('created_at')
                ->missing('updated_at')
                ->missing('deleted_at')
                ->etc()
            )
            ->etc()
        );

    $this->assertDatabaseCount('products', 25);
});
