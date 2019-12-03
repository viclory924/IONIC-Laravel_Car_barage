<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToWorkshopRateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('workshop_rate', function(Blueprint $table)
		{
			$table->foreign('customer_id', 'customer_fk_rate')->references('id')->on('customer')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('workshop_id', 'workshop_rate_fk')->references('id')->on('workshop')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('workshop_rate', function(Blueprint $table)
		{
			$table->dropForeign('customer_fk_rate');
			$table->dropForeign('workshop_rate_fk');
		});
	}

}
