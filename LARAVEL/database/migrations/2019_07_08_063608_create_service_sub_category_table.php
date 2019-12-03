<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServiceSubCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('service_sub_category', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('cat_id')->nullable()->index('service_sub_category_fk');
			$table->string('ar_name')->nullable();
			$table->string('en_name')->nullable();
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
		Schema::drop('service_sub_category');
	}

}
