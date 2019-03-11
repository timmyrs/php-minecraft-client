<?php
namespace Phpcraft;
class NbtIntArray extends NbtTag
{
	/**
	 * The integers in the array.
	 * @var array $children
	 */
	public $children;

	/**
	 * The constructor.
	 * @param string $name The name of this tag.
	 * @param array $children The integers in the array.
	 */
	function __construct($name, $children = [])
	{
		$this->name = $name;
		$this->children = $children;
	}

	/**
	 * @copydoc NbtTag::send
	 */
	function send(\Phpcraft\Connection $con, $inList = false)
	{
		if(!$inList)
		{
			$this->_send($con, 11);
		}
		$con->writeInt(count($this->children), true);
		foreach($this->children as $child)
		{
			$con->writeInt($child);
		}
	}

	function copy()
	{
		return new NbtIntArray($this->name, $this->children);
	}

	function toString()
	{
		$str = "{IntArray \"".$this->name."\":";
		foreach($this->children as $child)
		{
			$str .= " ".$child;
		}
		return $str."}";
	}
}