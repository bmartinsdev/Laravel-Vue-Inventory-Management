<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use App\Inventory;

$factory->define(Inventory::class, function (Faker $faker) {
	$faker->addProvider(new Bezhanov\Faker\Provider\Commerce($faker));
	return [
		'nome' => $faker->unique()->productName,
		'altura' => "50",
		'largura' => "30",
		'comprimento' => "265",
		'unidade_medida' => $faker->randomElement(array('mm','cm','m')),
		'custo' => rand(1,2)
	];
});
