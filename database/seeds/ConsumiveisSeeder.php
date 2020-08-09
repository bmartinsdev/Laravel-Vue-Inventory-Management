<?php

use Illuminate\Database\Seeder;
use App\GridHelper;

class ConsumiveisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
			$this->command->line('A adicionar 20 linhas a product categories.');
			factory('App\ProductCategory', 20)->create();
			GridHelper::setOption("categorias", App\ProductCategory::count(), "count");

			$this->command->line('A adicionar 200 linhas a produtos.');
			factory('App\Product', 100)->create();
			GridHelper::setOption("produtos", App\Product::count(), "count");
    }
}
