<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToWorkshopTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('workshop', function(Blueprint $table)
		{
			$table->foreign('city_id', 'workshop_list_city_id_fk')->references('id')->on('list_city')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('country_id', 'workshop_list_country_id_fk')->references('id')->on('list_country')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('workshop', function(Blueprint $table)
		{
			$table->dropForeign('workshop_list_city_id_fk');
			$table->dropForeign('workshop_list_country_id_fk');
		});
	}

}
