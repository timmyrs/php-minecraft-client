<?php
namespace Phpcraft;
use Exception;
use Phpcraft\Event\Event;
abstract class PluginManager
{
	/**
	 * An array containing all the Plugins that are currently loaded.
	 *
	 * @var array $loaded_plugins
	 */
	public static $loaded_plugins = [];

	/**
	 * Loads all plugins in a folder.
	 *
	 * @param string $plugins_folder The path to the folder in which plugins are contained.
	 */
	static function loadPlugins(string $plugins_folder = "plugins")
	{
		foreach(scandir($plugins_folder) as $file)
		{
			if(substr($file, -4) == ".php" && is_file($plugins_folder."/".$file))
			{
				$name = substr($file, 0, -4);
				try
				{
					$plugin = new Plugin($plugins_folder, $name);
					array_push(self::$loaded_plugins, $plugin);
				}
				catch(Exception $e)
				{
					echo "Unhandled exception in plugin \"$name\": ".get_class($e).": ".$e->getMessage()."\n".$e->getTraceAsString()."\n";
				}
			}
		}
	}

	/**
	 * Fires an Event to all loaded plugins.
	 *
	 * @param Event $event
	 * @return boolean True if the event was cancelled.
	 */
	static function fire(Event $event)
	{
		$type = get_class($event);
		$handlers = [];
		foreach(PluginManager::$loaded_plugins as $plugin)
		{
			if(isset($plugin->event_handlers[$type]))
			{
				array_push($handlers, $plugin->event_handlers[$type]);
			}
		}
		usort($handlers, function(array $a, array $b)
		{
			return $b["priority"] - $a["priority"];
		});
		try
		{
			foreach($handlers as $handler)
			{
				$handler["function"]($event);
			}
		}
		catch(Exception $e)
		{
			echo "Unhandled exception in plugin: ".get_class($e).": ".$e->getMessage()."\n".$e->getTraceAsString()."\n";
		}
		return $event->cancelled;
	}
}
