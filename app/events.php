<?php

Event::listen('create.product.name', function(&$name) {
	$name = trim($name);

	$name = str_replace('AH ', '', $name);

	$name = urlencode($name);
	$name = str_replace('%C2%AD', '', $name);
	$name = urldecode($name);
});

Event::listen('create.product.price', function(&$price) {

	$price = (float) str_replace(',', '.', $price);

	dd($price);
});
