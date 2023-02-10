<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->integer('price');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class)->constrained();
            $table->string('location');
            $table->string('alias');
            $table->string('original_name');
            $table->string('mime_type');
            $table->timestamps();
        });

        Schema::create('category_product', function (Blueprint $table) {
            $table->foreignIdFor(Category::class);
            $table->foreignIdFor(Product::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories_products');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
    }
};
