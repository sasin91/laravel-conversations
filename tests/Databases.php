<?php

namespace Sasin91\LaravelConversations\Tests;

use Sasin91\LaravelConversations\Migrations\CreateConversableTables;
use Sasin91\LaravelConversations\Tests\Migrations\CreateUsersTable;

trait Databases
{
	protected function setupDatabases()
	{
		(new CreateUsersTable)->up();
		(new CreateConversableTables)->up();
	}
}
