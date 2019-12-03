<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWorkshopRateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('workshop_rate', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('customer_id')->nullable()->index('customer_fk_rate');
			$table->integer('workshop_id')->nullable()->index('workshop_rate_fk');
			$table->integer('rate')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('workshop_rate');
	}

}
