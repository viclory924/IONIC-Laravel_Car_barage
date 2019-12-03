<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAddressTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('address', function(Blueprint $table)
		{
			$table->integer('id')->primary();
			$table->string('ar_name')->nullable();
			$table->string('en_name')->nullable();
			$table->string('logo')->nullable();
			$table->string('location')->nullable();
			$table->string('ar_description')->nullable();
			$table->string('en_description')->nullable();
			$table->integer('country_id')->nullable()->index('workshop_fk');
			$table->integer('city_id')->nullable()->index('workshop_city_fk_city');
			$table->string('address')->nullable();
			$table->string('email')->nullable();
			$table->string('mobile', 20)->nullable();
			$table->string('telephone', 20)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('address');
	}

}
