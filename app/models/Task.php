<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Task extends Eloquent  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tasks';

	protected $fillable = array('class', 'method', 'params');

	/**
	 *
	 * @param string $value
	 * @return array
	 */
	public function getParamsAttribute($value)
	{
		return json_decode($value, true);
	}

	/**
	 *
	 * @param array $value
	 */
	public function setParamsAttribute(Array $value)
	{
		$this->attributes['params']  = json_encode($value);
	}

	/**
	 * @param $name
	 * @param $uri
	 * @return Task
	 */
	public static function scrape($name, $uri)
	{
		return static::create(array(
			'class' => 'scraper',
			'method' => 'scrape',
			'params' => compact('name', 'uri'),
		));
	}

}
