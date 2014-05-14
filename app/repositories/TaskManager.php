<?php

use Illuminate\Container\Container;

class TaskManager
{
	protected $container;

	/**
	 * @param $name
	 * @param $uri
	 * @return Task
	 */
	public static function scrape($name, $uri)
	{
		return Task::create(array(
			'class' => '',
			'method' => '',
			'params' => compact('name', 'uri'),
		));
	}

	public function __construct(Container $container)
	{
		$this->container = $container;
	}

	/**
	 * @param $limit
	 */
	public function run($limit)
	{
		foreach(Task::take($limit)->get() as $task) {
			try {
				$this->runTask($task);
				$task->delete();
			}
			catch(Exception $e) {

			}
		}
	}

	/**
	 * Try to dispatch controller
	 *
	 * @param string $controller
	 * @param array|null $args named method arguments
	 * @return mixed content returned by method
	 * @throws \RuntimeException when insufficient number of arguments was passed
	 */
	public function runTask(Task $task) {

		$class = $task->class;
		$method = $task->method;
		$params = $task->params;

		$object = $this->container->make($class);
		$reflection = new \ReflectionObject($object);
		$reflected_method = $reflection->getMethod($method);

		$call_args = $this->prepareArguments($reflected_method, $params);

		return call_user_func_array(array($object, $method), array_values($call_args));
	}

	private function prepareArguments(\ReflectionMethod $method, array $args = null) {
		$arguments = array();

		if(null === $args) {
			$args = array();
		}

		foreach($method->getParameters() as $param) {
			$name = $param->name;

			if(true === array_key_exists($name, $args)) {
				$arguments[$name] = $args[$name];
			}
			else if (true === $param->isDefaultValueAvailable()) {
				$arguments[$name] = $param->getDefaultValue();
			}
			else {
				throw new \RuntimeException("Argument [{$name}] is required");
			}
		}

		return $arguments;
	}
}
