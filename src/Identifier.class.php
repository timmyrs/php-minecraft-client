<?php
namespace Phpcraft;
abstract class Identifier
{
	/**
	 * The name of this Identifier.
	 * @var string $name
	 */
	public $name;
	/**
	 * The protocol version at which this Identifier was introduced.
	 * @var integer $since_protocol_version
	 */
	public $since_protocol_version;

	/**
	 * Returns everything of this type.
	 * @return array
	 */
	abstract static function all();

	/**
	 * Returns the ID of this Identifier for the given protocol version or null if not applicable.
	 * @param integer $protocol_version
	 * @return integer
	 */
	abstract function getId($protocol_version);

	/**
	 * Returns an Identifier by its name or null if not found.
	 * @param string $name
	 * @return Identifier
	 */
	static function get($name)
	{
		$name = strtolower($name);
		if(substr($name, 0, 10) == "minecraft:")
		{
			$name = substr($name, 10);
		}
		foreach(static::all() as $thing)
		{
			if($thing->name == $name)
			{
				return $thing;
			}
		}
	}

	/**
	 * Returns an Identifier by its ID in the given protocol version or null if not found.
	 * @param integer $id
	 * @param integer $protocol_version
	 * @return Identifier
	 */
	static function getById($id, $protocol_version)
	{
		foreach(static::all() as $thing)
		{
			if($thing->getId($protocol_version) == $id)
			{
				return $thing;
			}
		}
	}
}