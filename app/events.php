<?php

Event::listen('create.product.name', function(&$name) {
	$name = trim($name);

	$name = str_replace('AH ', '', $name);
	$name = str_replace('AH ', '', $name);

	$name = urlencode($name);
	$name = str_replace('%C2%AD', '', $name);
	$name = urldecode($name);
});

Event::listen('create.product.price', function(&$price) {

	$price = (float) str_replace(',', '.', $price);
});

Event::listen('create.product-detail.label', function(&$label) {
	$label = trim($label);

	$label = urlencode($label);
	$label = str_replace('%C2%AD', '', $label);
	$label = urldecode($label);
});




Event::listen('product.search', function($q, $input) {

	if(isset($input['q'])) {
		$q->where('name', 'LIKE', '%' . $input['q'] . '%');
	}
});

Event::listen('product.search', function($q, $input) {

	$limit = isset($input['limit']) ? $input['limit'] : 10;
	$q->take($limit);

});

Event::listen('product.search', function($q, $input) {

	if(!isset($input['with'])) {
		return;
	}

	$valid = array('details', 'cheapest');
	$with = explode(',', $input['with']);

	foreach($with as $relation) {

		if(!in_array($relation, $valid)) {
			continue;
		}

		$q->with($relation);
	}

});


Event::listen('product.search', function($q, $input) {

	if(!isset($input['stores'])) {
		return;
	}

	$stores = explode(',', $input['stores']);

	$q->whereHas('stores', function($q) use($stores) {
		$q->whereIn('slug', $stores);
	});
});


