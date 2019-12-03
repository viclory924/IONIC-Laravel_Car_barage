<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserNotificationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_notification', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id')->unsigned()->nullable()->default(0)->index('FK_notification_users');
			$table->string('note')->nullable()->default('0');
			$table->dateTime('issue_date')->nullable();
			$table->integer('status')->nullable()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_notification');
	}

}
