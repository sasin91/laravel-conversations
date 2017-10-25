<?php

namespace Sasin91\LaravelConversations\Tests;

use Sasin91\LaravelConversations\Migrations\CreateConversationParticipantsTable;
use Sasin91\LaravelConversations\Migrations\CreateConversationRepliesTable;
use Sasin91\LaravelConversations\Migrations\CreateConversationsTable;
use Sasin91\LaravelConversations\Migrations\CreateInvitationsTable;
use Sasin91\LaravelConversations\Migrations\CreateReadablesTable;
use Sasin91\LaravelConversations\Tests\Migrations\CreateUsersTable;

trait Databases
{
	protected function setupDatabases()
	{
		(new CreateUsersTable)->up();
		(new CreateConversationsTable)->up();
		(new CreateConversationParticipantsTable)->up();
		(new CreateConversationRepliesTable)->up();
		(new CreateReadablesTable)->up();
		(new CreateInvitationsTable)->up();
	}
}
