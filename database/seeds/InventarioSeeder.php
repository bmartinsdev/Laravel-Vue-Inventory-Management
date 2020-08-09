<?php

use Illuminate\Database\Seeder;
use App\GridHelper;
use App\Room;

class InventarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
			$this->command->line('A adicionar 10 linhas a inventarios.');
			factory('App\Inventory', 10)->create();
			GridHelper::setOption("inventarios", App\Inventory::count(), "count");
	
			$this->command->line('A preencher lista de salas.');
			DB::table('rooms')->insert([
				['nome' => 'Sala 0.01'],
				['nome' => 'Sala 0.02'],
				['nome' => 'Sala 0.03'],
				['nome' => 'Sala 0.04'],
				['nome' => 'Sala 0.05'],
				['nome' => 'Sala 0.06'],
				['nome' => 'Sala 0.07'],
				['nome' => 'Sala 0.08'],
				['nome' => 'Sala 0.09'],
				['nome' => 'Sala 0.10'],
				['nome' => 'Sala 0.11'],
				['nome' => 'Sala 0.12'],
				['nome' => 'Sala 0.13'],
				['nome' => 'Sala 0.14'],
				['nome' => 'Sala 1.01'],	
				['nome' => 'Sala 1.02'],
				['nome' => 'Sala 1.03'],
				['nome' => 'Sala 1.04'],
				['nome' => 'Sala 1.05'],
				['nome' => 'Sala 1.06'],
				['nome' => 'Sala 1.07'],
				['nome' => 'Sala 1.08'],
				['nome' => 'Sala 1.09'],
				['nome' => 'Sala 1.10'],
				['nome' => 'Sala 1.11'],
				['nome' => 'Sala 1.12'],
				['nome' => 'Sala 1.13'],
				['nome' => 'Sala 1.14'],
				['nome' => 'Sala 1.15'],
				['nome' => 'Sala 1.16'],
				['nome' => 'Sala 1.17'],
				['nome' => 'Sala 1.18'],
				['nome' => 'Sala 1.19'],
				['nome' => 'Sala 1.20'],
				['nome' => 'Sala 1.21'],	
				['nome' => 'Sala 1.22'],
				['nome' => 'Sala 1.23'],
				['nome' => 'Sala 1.24'],
				['nome' => 'Sala 1.25'],
				['nome' => 'Sala 1.26'],
				['nome' => 'Sala 1.27'],	
			]);
			GridHelper::setOption("salas", App\Room::count(), "count");
	
			$this->command->line('A adicionar 999 linhas a unidades.');
			factory('App\Unit', 999)->create();
			GridHelper::setOption("unidades", App\Unit::count(), "count");
    }
}
