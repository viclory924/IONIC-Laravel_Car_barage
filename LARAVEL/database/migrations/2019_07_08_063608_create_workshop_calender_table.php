<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWorkshopCalenderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('workshop_calender', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('car_id')->nullable()->default(0)->index('FK_workshop_calender_car');
			$table->integer('user_id')->unsigned()->nullable()->default(0)->index('FK_workshop_calender_users');
			$table->integer('workshop_id')->nullable()->default(0)->index('FK_workshop_calender_workshop');
			$table->integer('request_id')->nullable()->index('FK_workshop_calender_workshop_request');
			$table->dateTime('date_in')->nullable();
			$table->dateTime('date_out')->nullable();
			$table->dateTime('issue_date')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('workshop_calender');
	}

}
