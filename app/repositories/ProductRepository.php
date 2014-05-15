<?php

class ProductRepository
{
	/**
	 * @param $term
	 * @return mixed
	 */
	public static function search($term)
	{
		return static::searchQuery($term)->get();
	}

	/**
	 * @param $term
	 * @return mixed
	 */
	public static function searchQuery($term)
	{
		$q = Product::query();
		$q->where('name', 'LIKE', '%' . $term . '%');

		return $q;
	}
}
