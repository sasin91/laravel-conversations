<?php

namespace Sasin91\LaravelConversations\Tests\Unit;

use Illuminate\Support\Facades\Event;
use Sasin91\LaravelConversations\Config\Models;
use Sasin91\LaravelConversations\Models\Concerns\CanBeRead;
use Sasin91\LaravelConversations\Models\Conversation;
use Sasin91\LaravelConversations\Observers\ConversationObserver;
use Sasin91\LaravelConversations\Tests\Fixtures\Users;
use Sasin91\LaravelConversations\Tests\TestCase;

class ConversationTest extends TestCase
{
	/** @test */
	function it_can_be_read()
	{
		self::assertContains(CanBeRead::class, class_uses_recursive(Models::name('conversation')));

		/** @var Conversation $conversation */
		$conversation = Users::john()->conversations()->create(['topic' => 'hello world', 'requires_invitation' => false]);
		Users::jane()->attend($conversation);

		$this->assertFalse(Users::jane()->hasRead($conversation));

		Users::jane()->markAsRead($conversation);

		$this->assertTrue(Users::jane()->hasRead($conversation));
	}

	/** @test */
	function it_assigns_first_participant_as_creator_when_undefined() 
	{
		Event::fake();

		$conversation = Users::john()->conversations()->create(['topic' => 'hello world']);
		
		Event::assertDispatched(
			'eloquent.saving: Sasin91\LaravelConversations\Models\Conversation',
			function($e, $m) {
				(new ConversationObserver)->saving($m);

				return true;
			});
		
		$this->assertTrue(
			$conversation->creator->is($conversation->participants->first())
		);
	} 
}
