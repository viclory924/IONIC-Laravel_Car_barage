<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('workshop_id')->nullable();
			$table->string('name')->nullable();
			$table->string('image')->nullable();
			$table->string('email')->nullable()->unique();
			$table->string('mobile', 20)->nullable()->unique('mobile');
			$table->dateTime('email_verified_at')->nullable();
			$table->string('password')->nullable();
			$table->string('remember_token', 100)->nullable();
			$table->timestamps();
			$table->integer('active')->nullable();
			$table->string('type', 10)->nullable();
			$table->unique(['workshop_id','type'], 'customer_id_type');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
