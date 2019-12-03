<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToWorkshopCalenderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('workshop_calender', function(Blueprint $table)
		{
			$table->foreign('car_id', 'FK_workshop_calender_car')->references('id')->on('car')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('user_id', 'FK_workshop_calender_users')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('workshop_id', 'FK_workshop_calender_workshop')->references('id')->on('workshop')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('request_id', 'FK_workshop_calender_workshop_request')->references('id')->on('workshop_request')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('workshop_calender', function(Blueprint $table)
		{
			$table->dropForeign('FK_workshop_calender_car');
			$table->dropForeign('FK_workshop_calender_users');
			$table->dropForeign('FK_workshop_calender_workshop');
			$table->dropForeign('FK_workshop_calender_workshop_request');
		});
	}

}
