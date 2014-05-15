<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_details', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();

			$table->integer('store_id');
			$table->integer('product_id');
			$table->string('label');
			$table->string('price');

			$table->unique(array('store_id', 'product_id'));
			$table->index('label');
			$table->index('price');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_details');
	}

}
