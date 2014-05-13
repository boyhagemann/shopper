<?php

class TaskRepository
{
	public static function addPage($name, $uri)
	{
		return Task::create(array(
			'class' => ''
		));
	}
}
