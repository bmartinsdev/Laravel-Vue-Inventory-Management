<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('students', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('codigo')->unique();
			$table->string('nome');
			$table->bigInteger('locker_id')->unsigned()->nullable();
			$table->foreign('locker_id')->references('id')->on('lockers')->onDelete('set null');
			$table->bigInteger('course_id')->unsigned()->nullable();
			$table->foreign('course_id')->references('id')->on('courses')->onDelete('set null');
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
		Schema::dropIfExists('students');
	}
}
