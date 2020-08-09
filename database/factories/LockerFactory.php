<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Locker;
use Faker\Generator as Faker;

$factory->define(Locker::class, function (Faker $faker) {
	return [
		'nome' => $faker->unique()->postcode,
		'area_id' => $faker->numberBetween(1, 20),
		'typology_id' => $faker->numberBetween(1, 6),
		'state_id' => 1
	];
});
