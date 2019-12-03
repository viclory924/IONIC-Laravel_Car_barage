<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToWorkshopCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('workshop_categories', function(Blueprint $table)
		{
			$table->foreign('sub_cat_id', 'workshop_categories_service_sub_category_id_fk')->references('id')->on('service_sub_category')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('workshop_id', 'workshop_categories_workshop_id_fk')->references('id')->on('workshop')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('workshop_categories', function(Blueprint $table)
		{
			$table->dropForeign('workshop_categories_service_sub_category_id_fk');
			$table->dropForeign('workshop_categories_workshop_id_fk');
		});
	}

}
