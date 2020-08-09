<?php

use Illuminate\Database\Seeder;
use App\GridHelper;
use App\Student;

class CacifosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
			$this->command->line('A adicionar 20 linhas a areas.');
			factory('App\Area', 20)->create();
			GridHelper::setOption("locais", App\Area::count(), "count");

			$this->command->line('A adicionar 6 linhas a topologias.');
			DB::table('typologies')->insert([
				['nome' => '2 Portas'],
				['nome' => '4 Portas'],
				['nome' => '6 Portas'],
				['nome' => 'Horizontal'],
				['nome' => 'Vertical'],
				['nome' => 'Redondo'],
			]);
			GridHelper::setOption("topologias", App\Typology::count(), "count");

			$this->command->line('A adicionar 200 linhas a cacifos.');
			factory('App\Locker', 200)->create();
			GridHelper::setOption("cacifos", App\Locker::count(), "count");

			$this->command->line('A adicionar 20 linhas a turmas.');
			factory('App\Course', 20)->create();
			GridHelper::setOption("turmas", App\Course::count(), "count");

			$this->command->line('A adicionar 200 linhas a formandos.');
			factory('App\Student', 200)->create();
			GridHelper::setOption("formandos", App\Course::count(), "count");
    }
}
