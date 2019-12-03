<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateListCityTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('list_city', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('country_id')->nullable()->index('list_city_fk');
			$table->string('ar_name')->nullable();
			$table->string('en_name')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('list_city');
	}

}
