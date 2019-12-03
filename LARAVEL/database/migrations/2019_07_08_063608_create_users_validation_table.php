<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersValidationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_validation', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id')->unsigned()->nullable()->index('FK_users_validation_users');
			$table->string('send_to')->nullable();
			$table->string('code')->nullable();
			$table->dateTime('expired_date')->nullable();
			$table->integer('valid')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users_validation');
	}

}
