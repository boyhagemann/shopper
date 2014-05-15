<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Product extends Eloquent  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'products';

	protected $hidden = array('id', 'created_at', 'updated_at');

	protected $fillable = array('name');

	/**
	 * @return ProductDetail[]
	 */
	public function details()
	{
		return $this->hasMany('ProductDetail');
	}

	/**
	 * @return ProductDetail[]
	 */
	public function cheapest()
	{
		return $this->hasOne('ProductDetail')->orderBy('price');
	}
}
