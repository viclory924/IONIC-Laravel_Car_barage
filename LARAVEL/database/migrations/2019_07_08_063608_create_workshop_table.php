<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWorkshopTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('workshop', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('country_id')->nullable()->index('workshop_list_country_id_fk');
			$table->integer('city_id')->nullable()->index('workshop_list_city_id_fk');
			$table->string('logo')->nullable();
			$table->string('ar_name')->nullable();
			$table->string('en_name')->nullable();
			$table->string('ar_description')->nullable();
			$table->string('en_description')->nullable();
			$table->string('ar_address')->nullable();
			$table->string('en_address')->nullable();
			$table->string('mobile')->nullable();
			$table->string('email')->nullable();
			$table->string('telephone')->nullable();
			$table->string('website')->nullable();
			$table->string('google_lat', 45)->nullable();
			$table->string('google_lng', 45)->nullable();
			$table->string('start_from', 50)->nullable();
			$table->string('end_at', 50)->nullable();
			$table->float('totl_rate', 10, 0)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('workshop');
	}

}
