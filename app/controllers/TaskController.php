<?php

class TaskController extends BaseController {

	/**
	 * @param $name
	 * @param $uri
	 */
	public function scrape($name, $uri)
	{
		$container = App::make('Boyhagemann\Scrape\Container');
		$page = $container->getPage($name);
		$page->scan($uri);
	}
}
