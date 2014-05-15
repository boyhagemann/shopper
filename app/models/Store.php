<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Store extends Eloquent  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'stores';

	protected $hidden = array('id', 'created_at', 'updated_at', 'slug');

	protected $fillable = array('name');

	/**
	 * @return ProductDetail[]
	 */
	public function productDetails()
	{
		return $this->hasMany('ProductDetail');
	}
}
