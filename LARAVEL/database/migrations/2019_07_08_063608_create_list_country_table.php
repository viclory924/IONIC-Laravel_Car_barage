<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateListCountryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('list_country', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('ar_name')->nullable();
			$table->string('en_name')->nullable();
			$table->string('code', 5)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('list_country');
	}

}
