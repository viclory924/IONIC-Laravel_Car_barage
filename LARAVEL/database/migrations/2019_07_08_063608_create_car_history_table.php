<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCarHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('car_history', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('car_id')->nullable()->default(0)->index('FK_car_history_car');
			$table->integer('user_id')->unsigned()->nullable()->default(0)->index('FK_car_history_users');
			$table->integer('workshop_id')->nullable()->default(0)->index('FK_car_history_workshop');
			$table->string('note')->nullable()->default('0');
			$table->dateTime('date_in')->nullable();
			$table->dateTime('date_out')->nullable();
			$table->float('price', 10, 0)->nullable()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('car_history');
	}

}
