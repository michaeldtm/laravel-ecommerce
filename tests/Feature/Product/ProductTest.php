<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductFeature;
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
            ->has(ProductFeature::factory()->count(2), 'features')
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

it('allows to create a new product', function () {
    $categories = Category::factory()->count(2)->create();

    $features = ProductFeature::factory()->count(2)->make();

    $product = Product::factory()->make();
    $product->categories = $categories->pluck('id')->toArray();
    $product->features = collect($features->toArray())->flatten()->toArray();

    loginAsUser();

    $this->postJson(route('products.store'), $product->toArray())
        ->assertOk()
        ->assertJson([
            'message' => __('messages.product.created')
        ]);

    $this->assertDatabaseHas('products', ['name' => $product->name]);
    $this->assertDatabaseHas('product_features', ['description' => $features->first()->description]);
    $this->assertDatabaseHas('category_product', ['category_id' => $categories->first()->id]);
});

it('requires valid data to create a new product', function ($data, $errors) {
    loginAsUser();

    $this->postJson(route('products.store'), $data)->assertInvalid($errors);
})->with([
    'name missing' => [['full_name' => null], ['name' => 'required']],
    'description' => [['description' => null], ['description' => 'required']],
    'price missing' => [['price' => null], ['price' => 'required']],
    'price is zero' => [['price' => 0], ['price' => 'greater than']],
    'price below zero' => [['price' => -1], ['price' => 'greater than']],
    'categories missing' => [['categories' => null], ['categories' => 'required']],
    'non existing category' => [['categories' => [1]], ['categories.0' => 'invalid']]
]);

it('get specific product information', function () {
    $user = loginAsUser();

    $product = Product::factory()
        ->has(Category::factory()->count(2))
        ->has(ProductFeature::factory()->count(2), 'features')
        ->for($user)->create();

    $this->getJson(route('products.show', $product->sku))
        ->assertOk()
        ->assertJson(fn (AssertableJson $json) =>
            $json->where('data.name', $product->name)
                ->hasAll(['data.categories', 'data.features'])
                ->etc()
        );
});

it('allows to update an existing product', function () {
    $user = loginAsUser();

    $product = Product::factory()
        ->has(Category::factory()->count(2))
        ->has(ProductFeature::factory()->count(2), 'features')
        ->for($user)->create();

    $category = Category::factory()->create();

    $categories = $product->categories;
    $features = $product->features;

    $this->putJson(route('products.update', $product->sku), [
        ...$product->only(['name', 'description', 'price']),
        'name' => 'Test product name',
        'categories' => [
            3
        ],
        'features' => [
            'This is a great way to test something',
            'This is another great feature from this product'
        ]
    ])->assertOk()
        ->assertJson([
            'message' => __('messages.product.updated')
        ]);

    $this->assertDatabaseHas('products', ['sku' => $product->sku, 'name' => 'Test product name']);
    $this->assertDatabaseHas('product_features', [
        'product_id' => $product->id,
        'description' => 'This is a great way to test something',
    ]);
    $this->assertDatabaseMissing('product_features', [
        'product_id' => $product->id,
        'description' => $features->first()->description,
    ]);
    $this->assertDatabaseHas('category_product', ['product_id' => $product->id, 'category_id' => $category->id]);
    $this->assertDatabaseMissing('category_product', [
        'product_id' => $product->id,
        'category_id' => $categories->first()->id,
    ]);
});
