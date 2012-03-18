<?php namespace App\CommandHandlers;

use LCQRS\Bus;
use App\Events\RolesUnassignedFromAccount;
use App\AggregateRoots\Account;

class UnassignRolesFromAccount {
	
	public function __construct($command)
	{
		$account = new Account;
		$account->unassign_roles($command->attributes);
		Bus::publish(new RolesUnassignedFromAccount($command->attributes));
	}

}