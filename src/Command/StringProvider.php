<?php /** @noinspection PhpUnusedParameterInspection */
namespace Phpcraft\Command;
/**
 * Provides a SingleWordStringArgument as PHP's native string to commands.
 */
class StringProvider extends ArgumentProvider
{
	function __construct(CommandSender &$sender, string $arg)
	{
		$this->value = $arg;
	}

	/**
	 * @return string
	 */
	function getValue(): string
	{
		return $this->value;
	}
}
