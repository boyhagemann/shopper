<?php namespace Boyhagemann\Scrape;

use Illuminate\Support\ServiceProvider;
use Boyhagemann\Scrape\Container;
use Symfony\Component\DomCrawler\Crawler;
use PageCrawl;

class ScrapeServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		/**
		 * Maak een singleton van de container met alle pages
		 */
		$this->app->singleton('Boyhagemann\Scrape\Container', function($app) {

			$container = new Container;
			$container->buildPage(function() use ($app) {
				return $app->make('Boyhagemann\Scrape\Page');
			});

			/**
			 * Startpagina met alle categorie-links. Hier scannen we de links
			 * om een overzicht van producten te krijgen.
			 *
			 * @see http://www.ah.nl/appie/producten
			 */
			$container->addPage('ah-start', function(Crawler $crawler) {

				$crawler->filter('#category-landing a')->each(function (Crawler $node) {
					PageCrawl::create(array(
						'name' => 'ah-cat',
						'uri' => 'http://www.ah.nl' . $node->attr('href'),
					));
				});
			});

			/**
			 * Pagina met een carousel van de laatste 5 producten. Er staat een lees-meer
			 * link naar het overzicht van 60 producten.
			 *
			 * @see http://www.ah.nl/appie/producten/aardappel-groente-fruit
			 */
			$container->addPage('ah-cat', function(Crawler $crawler) {

				$crawler->filter('h2.h2 a')->each(function (Crawler $node) {
					PageCrawl::create(array(
						'name' => 'ah-product-list',
						'uri' => $node->attr('href'),
					));
				});
			});

			/**
			 * Dit is het overzicht van alle producten gepagineerd (60).
			 *
			 */
			$container->addPage('ah-product-list', function(Crawler $crawler) {

				$crawler->filter('.product')->each(function(Crawler $node) {

					$title = $node->filter('.detail h2')->first()->text();
					dd(utf8_decode(trim($title)));
				});
			});

			return $container;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
