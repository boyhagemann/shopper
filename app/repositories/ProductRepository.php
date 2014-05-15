<?php

class ProductRepository
{
	/**
	 * @param $term
	 * @return mixed
	 */
	public static function search(Array $input)
	{
		$q = Product::query();
		Event::fire('product.search', array($q, $input));
		return $q->get();
	}

}
