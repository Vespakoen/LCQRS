<?php namespace App\AggregateRoots;

use LCQRS\Model\EntityList;
use LCQRS\Model\AggregateRoot;

use App\Entities\Role;

use App\Events\RoleCreated;
use App\Events\AccountRegistered;
use App\Events\AccountUpdated;
use App\Events\RolesAssignedToAccount;
use App\Events\RolesUnAssignedFromAccount;

class Account extends AggregateRoot {

	public function __construct()
	{
		$this->roles = new EntityList;
	}

	public function register($attributes)
	{
		$this->apply(new AccountRegistered($attributes));
	}

	public function update($attributes)
	{
		$this->apply(new AccountUpdated($attributes));
	}

	public function assign_roles($attributes)
	{
		$this->apply(new RolesAssignedToAccount($attributes));
	}

	public function unassign_roles($attributes)
	{
		$this->apply(new RolesUnAssignedFromAccount($attributes));
	}



	protected function apply_account_registered(AccountRegistered $event)
	{
		$this->attributes = $event->attributes;
	}

	protected function apply_account_updated(AccountUpdated $event)
	{
		$this->attributes = array_merge($this->attributes, $event->attributes);
	}

	protected function apply_roles_assigned_to_account(RolesAssignedToAccount $event)
	{
		foreach($event->attributes['role_uuids'] as $role_uuid)
		{
			//$this->roles->add(new Role($role_uuid));
		}
	}

	protected function apply_roles_unassigned_from_account(RolesUnAssignedFromAccount $event)
	{
		foreach($event->attributes['role_uuids'] as $role_uuid)
		{
			//unset($this->attributes['roles'][$role_uuid]);
		}
	}

}