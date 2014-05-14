<?php

Route::get('/', function()
{
	DB::table('tasks')->truncate();
	DB::table('products')->truncate();
	Task::scrape('ah-start', 'http://www.ah.nl/appie/producten');
});

Route::get('/cron', function()
{
	App::make('TaskManager')->run(15);
});
