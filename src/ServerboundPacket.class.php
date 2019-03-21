<?php
namespace Phpcraft;
/**
 * The class for the IDs of packets sent to the server.
 */
class ServerboundPacket extends PacketId
{
	private static $all_cache;

	private static function nameMap()
	{
		return [
			"position_look" => "position_and_look",
			"flying" => "no_movement",
			"settings" => "client_settings",

			"keep_alive" => "keep_alive_response",
			"abilities" => "serverbound_abilities",
			"chat" => "serverbound_chat_message",
			"custom_payload" => "serverbound_plugin_message"
		];
	}

	/**
	 * @copydoc Identifier::all
	 */
	static function all()
	{
		if(!self::$all_cache)
		{
			self::$all_cache = self::_all("toServer", self::nameMap(), function($name, $pv)
			{
				return new ServerboundPacket($name, $pv);
			});
		}
		return self::$all_cache;
	}

	/**
	 * @copydoc Identifier::getId
	 */
	function getId($protocol_version)
	{
		if($protocol_version >= $this->since_protocol_version)
		{
			return $this->_getId($protocol_version, "toServer", self::nameMap());
		}
	}
}
