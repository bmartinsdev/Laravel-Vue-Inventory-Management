<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
			'nome' => $faker->unique()->productName,
			'quantidade' => $faker->numberBetween(0, 700),
			'category_id' => $faker->numberBetween(1,19)
    ];
});
