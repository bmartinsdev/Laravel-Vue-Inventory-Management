<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGridlogsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gridlogs', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('page', 4)->nullable();
			$table->string('action', 4)->nullable();
			$table->bigInteger('user_id')->nullable();
			$table->bigInteger('target_id')->nullable();
			$table->bigInteger('old_value')->nullable();
			$table->bigInteger('new_value')->nullable();
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
		Schema::dropIfExists('gridlogs');
	}
}