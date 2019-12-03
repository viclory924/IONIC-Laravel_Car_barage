<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToListCityTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('list_city', function(Blueprint $table)
		{
			$table->foreign('country_id', 'list_city_fk')->references('id')->on('list_country')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('list_city', function(Blueprint $table)
		{
			$table->dropForeign('list_city_fk');
		});
	}

}
