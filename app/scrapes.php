<?php

use Symfony\Component\DomCrawler\Crawler;

$container = App::make('Boyhagemann\Scrape\Container');

/**
 * Startpagina met alle categorie-links. Hier scannen we de links
 * om een overzicht van producten te krijgen.
 *
 * @see http://www.ah.nl/appie/producten
 */
$container->addPage('ah-start', function(Crawler $crawler) {

	$crawler->filter('#category-landing a')->each(function (Crawler $node) {
		Task::scrape('ah-cat', 'http://www.ah.nl' . $node->attr('href'));
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
		Task::scrape('ah-product-list',  $node->attr('href'));
	});
});

/**
 * Dit is het overzicht van alle producten gepagineerd (60).
 *
 */
$container->addPage('ah-product-list', function(Crawler $crawler) {

	$crawler->filter('.product')->each(function(Crawler $node) {

		$name = $node->filter('.detail h2')->first()->text();
		$price = $node->filter('.price ins')->first()->text();

		Event::fire('create.product.name', array(&$name));
		Event::fire('create.product.price', array(&$price));

		$slug = Str::slug($name);

		$product = Product::firstOrCreate(compact('slug'));
		$product->name = $name;
		$product->price = $price;
		$product->save();
	});
});