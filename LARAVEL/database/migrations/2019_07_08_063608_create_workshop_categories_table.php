<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWorkshopCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('workshop_categories', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('sub_cat_id')->nullable()->index('workshop_categories_service_sub_category_id_fk');
			$table->integer('workshop_id')->nullable()->index('workshop_categories_workshop_id_fk');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('workshop_categories');
	}

}
