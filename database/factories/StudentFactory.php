<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Student;
use Faker\Generator as Faker;

$factory->define(Student::class, function (Faker $faker) {
	return [
		'codigo' => 't0' . $faker->unique()->randomNumber(6),
		'nome' => $faker->unique()->name,
		'course_id' => $faker->numberBetween(1,20),
		'locker_id' => $faker->numberBetween(1,200)
	];
});
