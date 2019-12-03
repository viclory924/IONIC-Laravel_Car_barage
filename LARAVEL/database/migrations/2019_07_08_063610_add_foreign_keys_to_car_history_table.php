<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCarHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('car_history', function(Blueprint $table)
		{
			$table->foreign('car_id', 'FK_car_history_car')->references('id')->on('car')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('user_id', 'FK_car_history_users')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('workshop_id', 'FK_car_history_workshop')->references('id')->on('workshop')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('car_history', function(Blueprint $table)
		{
			$table->dropForeign('FK_car_history_car');
			$table->dropForeign('FK_car_history_users');
			$table->dropForeign('FK_car_history_workshop');
		});
	}

}
