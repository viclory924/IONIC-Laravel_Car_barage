<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToServiceSubCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('service_sub_category', function(Blueprint $table)
		{
			$table->foreign('cat_id', 'service_sub_category_fk')->references('id')->on('service_category')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('service_sub_category', function(Blueprint $table)
		{
			$table->dropForeign('service_sub_category_fk');
		});
	}

}
