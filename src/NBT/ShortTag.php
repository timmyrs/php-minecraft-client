<?php
namespace Phpcraft\NBT;
use Phpcraft\Connection;
class ShortTag extends NBT
{
	const ORD = 2;
	/**
	 * The value of this tag.
	 *
	 * @var int $value
	 */
	public $value;

	/**
	 * @param string $name The name of this tag.
	 * @param int $value The value of this tag.
	 */
	function __construct(string $name, int $value = 0)
	{
		$this->name = $name;
		$this->value = $value;
	}

	/**
	 * Adds the NBT tag to the write buffer of the connection.
	 *
	 * @param Connection $con
	 * @param boolean $inList Ignore this parameter.
	 * @return Connection $con
	 */
	function write(Connection $con, bool $inList = false): Connection
	{
		if(!$inList)
		{
			$this->_write($con);
		}
		$con->writeShort($this->value);
		return $con;
	}

	function __toString()
	{
		return "{Short \"".$this->name."\": ".$this->value."}";
	}

	/**
	 * @return ShortTag
	 */
	function copy(): ShortTag
	{
		return new ShortTag($this->name, $this->value);
	}

	/**
	 * Returns the NBT tag in SNBT (stringified NBT) format, as used in commands.
	 *
	 * @param bool $fancy
	 * @param boolean $inList Ignore this parameter.
	 * @return string
	 */
	function toSNBT(bool $fancy = false, bool $inList = false): string
	{
		return ($inList || !$this->name ? "" : self::stringToSNBT($this->name).($fancy ? ": " : ":")).$this->value."s";
	}
}
