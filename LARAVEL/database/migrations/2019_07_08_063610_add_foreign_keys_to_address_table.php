<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAddressTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('address', function(Blueprint $table)
		{
			$table->foreign('city_id', 'workshop_city_fk')->references('id')->on('list_city')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('country_id', 'workshop_fk')->references('id')->on('list_country')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('address', function(Blueprint $table)
		{
			$table->dropForeign('workshop_city_fk');
			$table->dropForeign('workshop_fk');
		});
	}

}
