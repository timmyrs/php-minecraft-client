<?php
namespace Phpcraft\Nbt;
use GMP;
use Phpcraft\Connection;
class NbtLong extends NbtTag
{
	const ORD = 4;
	/**
	 * The value of this tag.
	 *
	 * @var GMP $value
	 */
	public $value;

	/**
	 * @param string $name The name of this tag.
	 * @param GMP|string|integer $value The value of this tag.
	 */
	public function __construct(string $name, $value)
	{
		$this->name = $name;
		if(!$value instanceof GMP)
		{
			$value = gmp_init($value);
		}
		$this->value = $value;
	}

	/**
	 * Adds the NBT tag to the write buffer of the connection.
	 *
	 * @param Connection $con
	 * @param boolean $inList Ignore this parameter.
	 * @return Connection $con
	 */
	public function write(Connection $con, bool $inList = false)
	{
		if(!$inList)
		{
			$this->_write($con);
		}
		$con->writeLong($this->value, true);
		return $con;
	}

	public function copy()
	{
		return new NbtLong($this->name, $this->value);
	}

	public function __toString()
	{
		return "{Long \"".$this->name."\": ".$this->value."}";
	}
}