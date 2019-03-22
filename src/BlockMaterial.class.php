<?php
namespace Phpcraft;
class BlockMaterial extends Identifier
{
	private $legacy_id;
	/**
	 * The name of each Item dropped when this block is destroyed.
	 * @var array $drops
	 */
	public $drops;

	/**
	 * @copydoc Identifier::all
	 */
	static function all()
	{
		return [
			new BlockMaterial("air", 0),
			new BlockMaterial("stone", 1 << 4, ["stone"]),
			new BlockMaterial("grass_block", 2 << 4, ["grass_block"]),
			new BlockMaterial("dirt", 3 << 4, ["dirt"])
		];
	}

	/**
	 * The constructor.
	 * @param string $name The name without minecraft: prefix.
	 * @param integer $legacy_id The pre-flattening ID of this block material.
	 * @param integer $since_protocol_version The protocol version at which this block was introduced.
	 * @param array $drops The name of each Item dropped when this block is destroyed.
	 */
	function __construct($name, $legacy_id, $since_protocol_version = 0, $drops = [])
	{
		$this->name = $name;
		$this->legacy_id = $legacy_id;
		$this->since_protocol_version = $since_protocol_version;
		$this->drops = $drops;
	}

	/**
	 * @copydoc Identifier::getId
	 */
	function getId($protocol_version)
	{
		if($protocol_version >= $this->since_protocol_version)
		{
			if($protocol_version >= 346)
			{
				switch($this->name)
				{
					case "air": return 0;
					case "stone": return 1;
					case "grass_block": return 9;
					case "dirt": return 10;
				}
			}
			else
			{
				return $this->legacy_id;
			}
		}
		return null;
	}

	/**
	 * Returns each Item that are supposed to be dropped when this block is destroyed.
	 * @return array
	 */
	function getDrops()
	{
		$drops = [];
		foreach($this->drops as $name)
		{
			array_push($drops, Item::get($name));
		}
		return $drops;
	}
}
