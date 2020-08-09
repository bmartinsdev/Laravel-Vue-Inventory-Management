<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\ProductCategory;
use Faker\Generator as Faker;

$factory->define(ProductCategory::class, function (Faker $faker) {
	$faker->addProvider(new Bezhanov\Faker\Provider\Commerce($faker));
	return [
		'nome' => $faker->unique()->jobTitle,
		'avgref' => $faker->numberBetween(30, 400)
	];
});
