<?php

use Symfony\Component\DomCrawler\Crawler;

$faker = Faker\Factory::create('nl_NL');
dd(utf8_decode($faker->name));

Scraper::add('test', function(Crawler $crawler) {

	$crawler->filter('a._Zc')->each(function($node) {
		Scraper::scrape('product', 'https://www.google.nl' . $node->attr('href'));
	});
});

Scraper::add('product', function(Crawler $crawler) {

	$crawler->filter('.review-section-results .review-content')->each(function($node) {

		die($node->text());
	});
});

Scraper::scrape('test', 'https://www.google.nl/search?tbm=shop&q=laptops');








/**
 * Startpagina met alle categorie-links. Hier scannen we de links
 * om een overzicht van producten te krijgen.
 *
 * @see http://www.ah.nl/appie/producten
 */
Scraper::add('ah-start', function(Crawler $crawler) {

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
Scraper::add('ah-cat', function(Crawler $crawler) {

	$crawler->filter('h2.h2 a')->each(function (Crawler $node) {
		Task::scrape('ah-product-list',  $node->attr('href'));
	});
});

/**
 * Dit is het overzicht van alle producten gepagineerd (60).
 *
 */
Scraper::add('ah-product-list', function(Crawler $crawler) {

	try {
	$crawler->filter('.product')->each(function(Crawler $node) {

		$label = $node->filter('.detail h2')->first()->text();
		$price = $node->filter('.price ins')->first()->text();

		ProductManager::add('ah', $label, $price);
	});

	}
	catch(Exception $e) {
		echo $crawler->first()->text();
		echo '<hr>';
	}
});