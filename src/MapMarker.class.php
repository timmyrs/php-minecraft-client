<?php
namespace Phpcraft;
/**
 * A marker on a map.
 * @see MapDataPacket
 */
class MapMarker
{
	/**
	 * A white arrow. Used in vanilla for on-map players.
	 */
	const TYPE_WHITE_ARROW = 0;
	/**
	 * A green arrow. Used in vanilla for item frames.
	 */
	const TYPE_GREEN_ARROW = 1;
	const TYPE_RED_ARROW = 2;
	const TYPE_BLUE_ARROW = 3;
	const TYPE_WHITE_CROSS = 4;
	const TYPE_RED_POINTER = 5;
	/**
	 * A white circle. Used in vanilla for off-map players.
	 */
	const TYPE_WHITE_CIRCLE = 6;
	/**
	 * A small white circle. Used in vanilla for far-off-map players.
	 */
	const TYPE_SMALL_WHITE_CIRCLE = 7;
	const TYPE_MANSION = 8;
	const TYPE_TEMPLE = 9;
	const TYPE_WHITE_BANNER = 10;
	const TYPE_ORANGE_BANNER = 11;
	const TYPE_MAGENTA_BANNER = 12;
	const TYPE_LIGHT_BLUE_BANNER = 13;
	const TYPE_YELLOW_BANNER = 14;
	const TYPE_LIME_BANNER = 15;
	const TYPE_PINK_BANNER = 16;
	const TYPE_GRAY_BANNER = 17;
	const TYPE_LIGHT_GRAY_BANNER = 18;
	const TYPE_CYAN_BANNER = 19;
	const TYPE_PURPLE_BANNER = 20;
	const TYPE_BLUE_BANNER = 21;
	const TYPE_BROWN_BANNER = 22;
	const TYPE_GREEN_BANNER = 23;
	const TYPE_RED_BANNER = 24;
	const TYPE_BLACK_BANNER = 25;
	const TYPE_TREASURE_MARKER = 26;

	/**
	 * The type of the marker. >= 9 will be replaced with 7 for clients below 1.13.
	 * @var integer $type
	 */
	public $type;
	/**
	 * The x coordinate of the marker on the map from -127 to 128.
	 * @var integer $x
	 */
	public $x;
	/**
	 * The z coordinate of the marker on the map from -127 to 128.
	 * @var integer $z
	 */
	public $z;
	/**
	 * The rotation of the marker divided by 22.5°, so it has a value between 0 and 15.
	 * @var integer $rotation
	 */
	public $rotation;
	/**
	 * The display name of this marker; chat object. Only visible to 1.13+ clients.
	 * @var array $name
	 */
	public $name;

	/**
	 * @param integer $type The type of the marker. >= 9 will be replaced with 7 for clients below 1.13.
	 * @param integer $x The x coordinate of the marker on the map from -127 to 128.
	 * @param integer $z The z coordinate of the marker on the map from -127 to 128.
	 * @param integer $rotation The rotation of the marker divided by 22.5°, so it has a value between 0 and 15.
	 * @param array $name The display name of this marker; chat object. Only visible to 1.13+ clients.
	 */
	public function __construct($type = 0, $x = 0, $z = 0, $rotation = 0, $name = [])
	{
		$this->type = $type;
		$this->x = $x;
		$this->z = $z;
		$this->rotation = $rotation;
		$this->name = $name;
	}

	public function __toString()
	{
		return "{Map Marker".($this->name ? " \"".Phpcraft::chatToText($this->name)."\"" : "")." at {$this->x}:{$this->z}, Type {$this->type}, ".($this->rotation * 22.5)."° Rotation}";
	}
}
