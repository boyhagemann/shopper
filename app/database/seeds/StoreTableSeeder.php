<?php

class StoreTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Store::create(array(
			'name' => 'Albert Heijn',
			'slug' => 'ah'
		));
	}

}
