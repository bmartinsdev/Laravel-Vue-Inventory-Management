<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('units', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('codigo')->unique();
			$table->bigInteger('inventory_id')->unsigned();
			$table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('cascade');
			$table->bigInteger('room_id')->unsigned()->nullable()->default(1);
			$table->foreign('room_id')->references('id')->on('rooms');
			$table->softDeletes();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('units');
	}
}
