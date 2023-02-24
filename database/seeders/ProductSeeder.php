<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductFeature;
use App\Models\ProductImage;
use App\Models\ProductReview;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $user = User::first();

        $products = collect([
            [
                'name' => 'Organize Basic Set (Walnut)',
                'price' => 149,
                'reviews' => 38,
                'images' => ['https://tailwindui.com/img/ecommerce-images/category-page-05-image-card-01.jpg'],
                'features' => [],
            ],
            [
                'name' => 'Organize Pen Holder',
                'price' => 15,
                'reviews' => 18,
                'images' => ['https://tailwindui.com/img/ecommerce-images/category-page-05-image-card-02.jpg'],
                'features' => [],
            ],
            [
                'name' => 'Organize Sticky Note Holder',
                'price' => 15,
                'reviews' => 14,
                'images' => ['https://tailwindui.com/img/ecommerce-images/category-page-05-image-card-03.jpg'],
                'features' => [],
            ],
            [
                'name' => 'Organize Phone Holder',
                'price' => 15,
                'reviews' => 21,
                'images' => ['https://tailwindui.com/img/ecommerce-images/category-page-05-image-card-04.jpg'],
                'features' => [],
            ],
            [
                'name' => 'Organize Small Tray',
                'price' => 15,
                'reviews' => 22,
                'images' => ['https://tailwindui.com/img/ecommerce-images/category-page-05-image-card-05.jpg'],
                'features' => [],
            ],
            [
                'name' => 'Organize Basic Set (Maple)',
                'price' => 149,
                'reviews' => 64,
                'images' => ['https://tailwindui.com/img/ecommerce-images/category-page-05-image-card-06.jpg'],
                'features' => [],
            ],
            [
                'name' => 'Out and About Bottle',
                'price' => 25,
                'reviews' => 12,
                'images' => ['https://tailwindui.com/img/ecommerce-images/category-page-05-image-card-07.jpg'],
                'features' => [],
            ],
            [
                'name' => 'Daily Notebook Refill Pack',
                'price' => 14,
                'reviews' => 41,
                'images' => ['https://tailwindui.com/img/ecommerce-images/category-page-05-image-card-08.jpg'],
                'features' => [],
            ],
            [
                'name' => 'Leather Key Ring (Black)',
                'price' => 32,
                'reviews' => 24,
                'images' => ['https://tailwindui.com/img/ecommerce-images/category-page-05-image-card-09.jpg'],
                'features' => [],
            ]
        ]);

        $products->each(function ($product) use ($user, $faker) {
            $model = new Product;
            $model->fill(collect($product)->only('name', 'price')->toArray());
            $model->description = $faker->text;

            DB::transaction(function () use ($user, $model, $product) {
                $newProduct = $user->products()->save($model);

                $images = [];
                foreach ($product['images'] as $image) {
                    $model = new ProductImage;
                    $images[] = $model->fill(['url' => $image]);
                }
                $newProduct->images()->saveMany($images);

                ProductFeature::factory()->for($newProduct)->count(rand(4, 6))->create();
                ProductReview::factory()->for($newProduct)->count(rand(15, 30))->create();
            });
        });
    }
}
