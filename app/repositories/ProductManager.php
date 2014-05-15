<?php

class ProductManager
{
	public static function add($store, $name, $price)
	{
		Event::fire('create.product.name', array(&$name));
		Event::fire('create.product.price', array(&$price));

		$name = Str::slug($name);

		$store = Store::where('name', $store)->firstOrFail();

		$product = Product::firstOrCreate(compact('name'));

		$detail = ProductDetail::firstOrCreate(compact(''));

	}
}
