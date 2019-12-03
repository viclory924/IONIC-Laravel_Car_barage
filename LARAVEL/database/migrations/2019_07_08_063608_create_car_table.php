<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCarTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('car', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id')->unsigned()->nullable()->default(0)->index('FK__users');
			$table->string('model', 50)->nullable();
			$table->string('origin', 50)->nullable();
			$table->string('vehicle_type', 50)->nullable();
			$table->string('eng_no', 50)->nullable();
			$table->string('chassis_no', 50)->nullable();
			$table->string('image')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('car');
	}

}
