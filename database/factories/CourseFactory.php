<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Course;
use Faker\Generator as Faker;

$factory->define(Course::class, function (Faker $faker) {
	return [
		'nome' => $faker->regexify('[A-Z]{4}[0-9]{4}')
	];
});
