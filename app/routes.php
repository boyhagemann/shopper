<?php

Route::get('/', function()
{
	Task::scrape('ah-start', 'http://www.ah.nl/appie/producten');
});

Route::get('/cron', function()
{
	App::make('TaskManager')->run(15);
});
