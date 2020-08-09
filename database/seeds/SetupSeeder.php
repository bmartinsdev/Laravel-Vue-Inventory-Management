<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\GridHelper;

class SetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
			DB::table('states')->insert([
				['nome' => 'Livre'],
				['nome' => 'Parcial'],
				['nome' => 'Ocupado']
			]);
			
			DB::table('rooms')->insert([
				['nome' => 'Armazém']
			]);
			DB::table('users')->insert([
				['name' => 'user', 
				'email' => 'user@user.com',
				'password' => Hash::make('123+qwe'),
				'perms' => 1],
				['name' => 'admin', 
				'email' => 'admin@admin.com',
				'password' => Hash::make('123+qwe'),
				'perms' => 2]
			]);

			GridHelper::setOption("utilizadores", App\Inventory::count(), "count");
    }
}
