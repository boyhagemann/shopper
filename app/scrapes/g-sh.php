<?php

use Symfony\Component\DomCrawler\Crawler;

$faker = Faker\Factory::create('nl_NL');
dd(utf8_decode($faker->firstName . ' ' . $faker->lastName));

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
