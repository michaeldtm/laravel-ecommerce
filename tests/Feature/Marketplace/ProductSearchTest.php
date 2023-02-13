<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductFeature;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Testing\Fluent\AssertableJson;

beforeEach(function () {
    $user = User::factory()->create();

    $categories = Category::factory()->count(5)
        ->state(new Sequence(
            ['name' => 'Smartphones'],
            ['name' => 'Women'],
            ['name' => 'Men'],
            ['name' => "Fragrance"],
            ['name' => 'Grocery']
        ))
        ->create();

    Product::factory()
        ->has(ProductFeature::factory()->count(2), 'features')
        ->for($user)
        ->create(['name' => 'Sample product']);

    $products = Product::factory()
        ->has(ProductFeature::factory()->count(2), 'features')
        ->for($user)
        ->count(10)
        ->create();

    $products->each(function ($product) use ($categories) {
        $product->categories()->sync($categories->random(2));
    });
});

it('allows to search products by name', function () {
    $this->getJson(route('marketplace') . '?filter[name]=Sample')
        ->assertOk()
        ->assertJson(fn (AssertableJson $json) =>
            $json->has('data', 1, fn ($json) => $json->where('name', 'Sample product')->etc())->etc()
        );
});

it('allows to search products by category', function () {
    Product::factory()
        ->has(Category::factory()->state(['name' => 'Random']))
        ->for(User::query()->first())
        ->create(['name' => 'Random product']);

    $this->getJson(route('marketplace') . '?filter[cat]=Random')
        ->assertOk()
        ->assertJson(fn (AssertableJson $json) =>
        $json->has('data', 1, fn ($json) => $json->where('name', 'Random product')->etc())->etc()
        );
});

it('allows to order products by name asc', function () {
    Product::factory()
        ->has(ProductFeature::factory()->count(2), 'features')
        ->for(User::query()->first())
        ->create(['name' => '0']);

    $this->getJson(route('marketplace') . '?sort=name')
        ->assertOk()
        ->assertJson(fn (AssertableJson $json) =>
            $json->has('data', 12)
                ->has('data.0', fn ($json) => $json->where('name', '0')->etc())
                ->etc()
        );
});

it('allows to order products by name desc', function () {
    Product::factory()
        ->has(ProductFeature::factory()->count(2), 'features')
        ->for(User::query()->first())
        ->create(['name' => 'z']);

    $this->getJson(route('marketplace') . '?sort=-name')
        ->assertOk()
        ->assertJson(fn (AssertableJson $json) =>
        $json->has('data', 12)
            ->has('data.0', fn ($json) => $json->where('name', 'z')->etc())
            ->etc()
        );
});

it('allows to order products by price asc', function () {
    Product::factory()
        ->has(ProductFeature::factory()->count(2), 'features')
        ->for(User::query()->first())
        ->create(['price' => '10']);

    $this->getJson(route('marketplace') . '?sort=price')
        ->assertOk()
        ->assertJson(fn (AssertableJson $json) =>
        $json->has('data', 12)
            ->has('data.0', fn ($json) => $json->where('price', 10)->etc())
            ->etc()
        );
});

it('allows to order products by price desc', function () {
    Product::factory()
        ->has(ProductFeature::factory()->count(2), 'features')
        ->for(User::query()->first())
        ->create(['price' => '60']);

    $this->getJson(route('marketplace') . '?sort=-price')
        ->assertOk()
        ->assertJson(fn (AssertableJson $json) =>
        $json->has('data', 12)
            ->has('data.0', fn ($json) => $json->where('price', 60)->etc())
            ->etc()
        );
});
