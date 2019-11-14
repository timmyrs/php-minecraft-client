<?php
namespace Phpcraft\Realms;
use hellsh\UUID;
use Phpcraft\Account;
class RealmsInvite
{
	/**
	 * @var Account $account
	 */
	public $account;
	/**
	 * @var int $id
	 */
	public $id;
	/**
	 * @var string $server_name
	 */
	public $server_name;
	/**
	 * @var string $server_description
	 */
	public $server_description;
	/**
	 * @var string $server_owner_name
	 */
	public $server_owner_name;
	/**
	 * @var UUID $server_owner_uuid
	 */
	public $server_owner_uuid;
	/**
	 * @var int $invite_time
	 */
	public $invite_time;

	/**
	 * @param Account $account
	 * @param array $data
	 */
	function __construct(Account $account, array $data)
	{
		$this->account = $account;
		$this->id = $data["invitationId"];
		$this->server_name = $data["worldName"];
		$this->server_description = $data["worldDescription"];
		$this->server_owner_name = $data["worldOwnerName"];
		$this->server_owner_uuid = new UUID($data["worldOwnerUuid"]);
		$this->invite_time = round($data["date"] / 1000);
	}

	/**
	 * @return void
	 */
	function accept(): void
	{
		$this->account->sendRealmsRequest("PUT", "/invites/accept/".$this->id);
	}

	/**
	 * @return void
	 */
	function reject(): void
	{
		$this->account->sendRealmsRequest("PUT", "/invites/reject/".$this->id);
	}
}