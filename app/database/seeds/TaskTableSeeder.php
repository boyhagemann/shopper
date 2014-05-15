<?php

class TaskTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Task::scrape('ah-product-list', 'http://www.ah.nl/appie/producten/groente/seizoensgroente?ah_campaign=intern&ah_mchannel=appieweb&ah_source=categoryaardappelgroentefruit&ah_linkname=meer-seizoensgroente.201411.category&ah_fee=0');
	}

}
