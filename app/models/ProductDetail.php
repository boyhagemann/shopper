<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class ProductDetail extends Eloquent  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'product_details';

	protected $fillable = array('store_id', 'name', 'price');

	/**
	 * @return Product
	 */
	public function product()
	{
		return $this->belongsTo('Product');
	}

	/**
	 * @return Store
	 */
	public function store()
	{
		return $this->belongsTo('Store');
	}
}
