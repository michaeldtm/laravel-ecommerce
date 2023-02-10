<?php

namespace App\Faker;

use Faker\Provider\Base;

class CategoryProvider extends Base
{
    protected static array $categoryName = [
        "Smartphone",
        "Laptop",
        "Fragrance",
        "Skincare",
        "Grocery",
        "Home",
        "Furniture",
        "Top",
        "Men",
        "Women",
        "Sunglass",
        "Automotive",
        "Motorcycle",
        "Lighting",
    ];

    public function categoryName(): string
    {
        return static::randomElement(static::$categoryName);
    }
}
