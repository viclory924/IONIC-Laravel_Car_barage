<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWorkshopRequestTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('workshop_request', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('car_id')->nullable()->default(0);
			$table->integer('workshop_id')->nullable()->default(0);
			$table->dateTime('request_dat')->nullable();
			$table->integer('action')->nullable()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('workshop_request');
	}

}
