<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::get('/', function()
{

	PageCrawl::create(array(
		'name' => 'ah-start',
		'uri' => 'http://www.ah.nl/appie/producten',
	));

});

Route::get('/cron', function()
{
	$container = App::make('Boyhagemann\Scrape\Container');

	foreach(PageCrawl::take(5)->get() as $crawl) {

		$page = $container->getPage($crawl->name);
		$page->scan($crawl->uri);
		$crawl->delete();
	}

});
