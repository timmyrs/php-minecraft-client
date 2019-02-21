<?php
namespace Phpcraft;
class Event
{
	const PRIORITY_HIGHEST = 2;
	const PRIORITY_HIGH = 1;
	const PRIORITY_NORMAL = 0;
	const PRIORITY_LOW = -1;
	const PRIORITY_LOWEST = -2;

	/**
	 * The name of the event.
	 * @var string $name
	 */
	public $name;
	/**
	 * Event data.
	 * @var array $data
	 */
	public $data;
	private $cancelled = false;

	/**
	 * The constructor.
	 * @param string $name
	 * @param array $data
	 */
	function __construct($name, $data = [])
	{
		$this->name = $name;
		$this->data = $data;
	}

	/**
	 * Tells you if the event was cancelled.
	 * @return boolean
	 */
	function isCancelled()
	{
		return $this->cancelled;
	}

	/**
	 * Cancels the event.
	 */
	function cancel()
	{
		$this->cancelled = true;
	}
}
