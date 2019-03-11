<?php
namespace Phpcraft;
class SetSlotPacket extends Packet
{
	/**
	 * The ID of the window being updated. 0 for inventory.
	 * @var integer $window
	 */
	public $window = 0;
	/**
	 * The ID of the slot being updated.
	 * @var integer $slotId
	 * @see https://wiki.vg/Inventory
	 */
	public $slotId = 0;
	/**
	 * The new value of the slot.
	 * @var Slot $slot
	 */
	public $slot = null;

	/**
	 * @copydoc Packet::read
	 */
	static function read(\Phpcraft\Connection $con)
	{
		$packet = new SetSlotPacket();
		$packet->window = $con->readByte();
		$packet->slotId = $con->readShort();
		$packet->slot = $con->readSlot();
		return $packet;
	}

	/**
	 * @copydoc Packet::send
	 */
	function send(\Phpcraft\Connection $con)
	{
		$con->startPacket("set_slot");
		$con->writeByte($this->window);
		$con->writeShort($this->slotId);
		$con->writeSlot($this->slot);
		$con->send();
	}

	function toString()
	{
		return "{Set Slot: Window ID {$this->window}, Slot ID {$this->slotId}, ".\Phpcraft\Slot::toString($this->slot)."}";
	}
}