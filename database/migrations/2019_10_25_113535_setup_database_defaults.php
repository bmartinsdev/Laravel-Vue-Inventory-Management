<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetupDatabaseDefaults extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Artisan::call('db:seed', ['--class' => SetupSeeder::class]);

		DB::unprepared('CREATE TRIGGER room_delete_rules BEFORE DELETE ON rooms 
			FOR EACH ROW
			BEGIN
				IF old.id = 1 THEN
					signal sqlstate "45000" set message_text = "Armazém não pode ser apagado.";
				END IF;
				UPDATE units SET room_id = 1 WHERE room_id = old.id;
			END');

		DB::unprepared('CREATE TRIGGER estados_block_delete BEFORE DELETE ON states 
			FOR EACH ROW
			BEGIN
				IF old.id IN (1, 2, 3) THEN
					signal sqlstate "45000" set message_text = "Estados não podem ser apagados.";
				END IF;
			END');

		DB::unprepared('CREATE TRIGGER students_locker_limit_create BEFORE INSERT ON students 
			FOR EACH ROW
			BEGIN
				IF (select COUNT(students.id) from students where students.locker_id = NEW.locker_id) >= 2 THEN
					SET NEW.locker_id = null;
				END IF;
			END');

		DB::unprepared('CREATE TRIGGER students_locker_limit_update BEFORE UPDATE ON students 
			FOR EACH ROW
			BEGIN
				IF (SELECT COUNT(students.id) FROM students WHERE students.locker_id = NEW.locker_id) >= 2 THEN
					SET NEW.locker_id = null;
				END IF;
			END');

		DB::unprepared('CREATE TRIGGER products_cor_update BEFORE UPDATE ON products 
			FOR EACH ROW
			BEGIN
			DECLARE percentagem int;
			SET @percentagem := NEW.quantidade * 100 / (SELECT product_categories.avgref FROM product_categories WHERE product_categories.id = NEW.category_id);
				IF (@percentagem < 10) THEN
					SET NEW.cor = "verm";
				ELSEIF (@percentagem < 25) THEN
					SET NEW.cor = "lara";
				ELSEIF (@percentagem < 50) THEN
					SET NEW.cor = "amar";
				ELSE
					SET NEW.cor = null;
				END IF;
			END');

		DB::unprepared('CREATE TRIGGER inventories_update_units_count_create AFTER INSERT ON units 
			FOR EACH ROW
			BEGIN
				UPDATE inventories 
				SET count_unidades = (select COUNT(units.inventory_id) from units where units.inventory_id = NEW.inventory_id) 
				WHERE id = NEW.inventory_id;
			END');

		DB::unprepared('CREATE TRIGGER inventories_update_units_count_delete AFTER DELETE ON units 
			FOR EACH ROW
			BEGIN
				UPDATE inventories 
				SET count_unidades = (select COUNT(units.inventory_id) from units where units.inventory_id = OLD.inventory_id) 
				WHERE id = OLD.inventory_id;
			END');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::unprepared('DROP TRIGGER room_delete_rules');
		DB::unprepared('DROP TRIGGER estados_delete_rules');
		DB::unprepared('DROP TRIGGER students_locker_limit_create');
		DB::unprepared('DROP TRIGGER students_locker_limit_update');
		DB::unprepared('DROP TRIGGER products_cor_update');
		DB::unprepared('DROP TRIGGER inventories_update_units_count_create');
		DB::unprepared('DROP TRIGGER inventories_update_units_count_delete');
	}
}
