<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use App\Unit;

$factory->define(Unit::class, function (Faker $faker) {
    return [
			'inventory_id' => $faker->numberBetween(1, 10),
			'room_id' => $faker->numberBetween(1, 41),
			'codigo' => $faker->unique()->randomNumber(6),
    ];
});
