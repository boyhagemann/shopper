<?php

class ProductManager
{
	public static function add($store, $label, $price)
	{
		$name = $label;
		Event::fire('create.product.name', array(&$name));
		Event::fire('create.product.price', array(&$price));


		$store = Store::where('slug', $store)->firstOrFail();

		Product::unguard();
		$name = Str::slug($name);
		$product = Product::firstOrCreate(compact('name'));

		$detail = ProductDetail::firstOrCreate(array(
			'store_id' => $store->id,
			'product_id' => $product->id
		));
		$detail->label = $label;
		$detail->price = $price;
		$detail->save();

	}
}
