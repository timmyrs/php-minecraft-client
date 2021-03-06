<?php
namespace Phpcraft\Entity;
use Phpcraft\
{ChatComponent, Connection, Exception\IOException};
class Base extends Metadata
{
	/**
	 * @var boolean|null $burning
	 */
	public $burning = null;
	/**
	 * @var boolean|null $crouching
	 */
	public $crouching = null;
	/**
	 * @var boolean|null $sprinting
	 */
	public $sprinting = null;
	/**
	 * @var boolean|null $swimming
	 */
	public $swimming = null;
	/**
	 * @var boolean|null $invisible
	 */
	public $invisible = null;
	/**
	 * @var boolean|null $glowing
	 */
	public $glowing = null;
	/**
	 * @var boolean|null $elytraing
	 */
	public $elytraing = null;
	/**
	 * Custom name of the entity.
	 *
	 * @var ChatComponent|null $custom_name
	 */
	public $custom_name = null;
	/**
	 * @var boolean|null $silent
	 */
	public $silent = null;

	static function getOffset(int $protocol_version): int
	{
		return $protocol_version >= 57 ? 7 : 6;
	}

	/**
	 * Writes non-null metadata values to the Connection's write buffer.
	 *
	 * @param Connection $con
	 * @return void
	 */
	function write(Connection $con): void
	{
		if($this->burning !== null || $this->crouching !== null || $this->sprinting !== null || $this->swimming !== null || $this->invisible !== null || $this->glowing !== null || $this->elytraing !== null)
		{
			$byte = 0;
			if($this->burning)
			{
				$byte |= 0x01;
			}
			if($this->crouching)
			{
				$byte |= 0x02;
			}
			if($this->sprinting)
			{
				$byte |= 0x08;
			}
			if($this->swimming && $con->protocol_version >= 358)
			{
				$byte |= 0x10;
			}
			if($this->invisible)
			{
				$byte |= 0x20;
			}
			if($this->glowing && $con->protocol_version >= 49)
			{
				$byte |= 0x40;
			}
			if($this->elytraing && $con->protocol_version >= 77)
			{
				$byte |= 0x80;
			}
			self::writeByte($con, 0, $byte);
		}
		if($this->silent !== null)
		{
			self::writeBoolean($con, 4, $this->silent);
		}
		if($this->custom_name !== null)
		{
			self::writeOptChat($con, 2, $this->custom_name);
		}
		if(get_called_class() == __CLASS__)
		{
			self::finish($con);
		}
	}

	/**
	 * @return array<string>
	 */
	function getStringAttributes(): array
	{
		$attr = [];
		if($this->custom_name !== null)
		{
			array_push($attr, "\"".$this->custom_name->toString()."\"");
		}
		if($this->burning !== null)
		{
			array_push($attr, ($this->burning ? "" : "Not ")."Burning");
		}
		if($this->crouching !== null)
		{
			array_push($attr, ($this->crouching ? "" : "Not ")."Crouching");
		}
		if($this->sprinting !== null)
		{
			array_push($attr, ($this->sprinting ? "" : "Not ")."Sprinting");
		}
		if($this->swimming !== null)
		{
			array_push($attr, ($this->swimming ? "" : "Not ")."Swimming");
		}
		if($this->invisible !== null)
		{
			array_push($attr, ($this->invisible ? "" : "Not ")."Invisible");
		}
		if($this->glowing !== null)
		{
			array_push($attr, ($this->glowing ? "" : "Not ")."Glowing");
		}
		if($this->elytraing !== null)
		{
			array_push($attr, ($this->elytraing ? "" : "Not ")."Elytraing");
		}
		if($this->silent !== null)
		{
			array_push($attr, ($this->silent ? "" : "Not ")."Silent");
		}
		return $attr;
	}

	/**
	 * @param Connection $con
	 * @param int $index
	 * @return boolean
	 * @throws IOException
	 */
	protected function read_(Connection $con, int $index): bool
	{
		switch($index)
		{
			case 0:
				$byte = $con->readByte();
				$this->elytraing = (($byte & 0x80) != 0 && $con->protocol_version >= 77);
				$this->glowing = (($byte & 0x40) != 0 && $con->protocol_version >= 49);
				$this->invisible = (($byte & 0x20) != 0);
				$this->swimming = (($byte & 0x10) != 0 && $con->protocol_version >= 358);
				$this->sprinting = (($byte & 0x08) != 0);
				$this->crouching = (($byte & 0x02) != 0);
				$this->burning = (($byte & 0x01) != 0);
				return true;
			case 2:
				if($con->protocol_version >= 57)
				{
					$this->custom_name = $con->readBoolean() ? $con->readChat() : null;
				}
				else
				{
					$name = $con->readString();
					if($name == "")
					{
						$this->custom_name = null;
					}
					else
					{
						$this->custom_name = ChatComponent::text($name);
					}
				}
				return true;
			case 4:
				$this->silent = $con->readBoolean();
				return true;
		}
		return false;
	}
}
