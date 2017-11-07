<?php

namespace Sasin91\LaravelConversations\Tests\Unit;

use Illuminate\Support\Facades\Event;
use Sasin91\LaravelConversations\Config\Models;
use Sasin91\LaravelConversations\Events\InvitationAccepted;
use Sasin91\LaravelConversations\Events\InvitationDeclined;
use Sasin91\LaravelConversations\Models\Conversation;
use Sasin91\LaravelConversations\Models\Invitation;
use Sasin91\LaravelConversations\Tests\Databases;
use Sasin91\LaravelConversations\Tests\Fixtures\Users;
use Sasin91\LaravelConversations\Tests\TestCase;
use function forward_static_call;

class ConversableTest extends TestCase
{
	use Databases;

	/** @test */
	public function can_start_a_conversation()
	{
		$john = Users::john();

		$conversation = $john->conversations()->create(['topic' => 'hello world']);

		$this->assertDatabaseHas(Models::table('participant'), [
			'user_id' => $john->getKey(),
			'conversation_id' => $conversation->getKey()
		]);
	}

	/** @test */
	public function can_decline_a_conversation_invitation()
	{
		Event::fake();

		$invitation = $this->conversationInviteForJane();
		$invitation->decline();

		Event::assertDispatched(InvitationDeclined::class);

		$this->assertFalse(Users::jane()->conversations->contains($invitation->conversation));

		$this->assertModelDeleted($invitation);
	}

	private function conversationInviteForJane(): Invitation
	{
		/** @var Conversation $conversation */
		$conversation = Users::john()->conversations()->create([
			'topic' => 'hello world',
			'requires_invitation' => true
		]);

		return tap($conversation->invitations()->create([
			'invitee_id' => Users::jane()->getKey(),
			'code' => 'invitation-code-1234'
		]), function (Invitation $invitation) {
			$invitation->setRelation('invitee', Users::jane());
		});

	}

	/** @test */
	public function can_accept_a_conversation_invitation()
	{
		Event::fake();

		$invitation = $this->conversationInviteForJane();
		$invitation->accept();

		Event::assertDispatched(InvitationAccepted::class);
		$this->assertTrue(Users::jane()->conversations->contains($invitation->conversation));
		$this->assertModelDeleted($invitation);
	}

	/** @test */
	public function can_attend_a_public_conversation()
	{
		/** @var Conversation $conversation */
		$conversation = Users::john()->conversations()->create(['topic' => 'hello world']);

		self::assertNotNull(Users::jane()->attend($conversation), "Could not join conversation.");

		$this->assertDatabaseHas(Models::table('participant'), [
			'user_id' => Users::jane()->getKey(),
			'conversation_id' => $conversation->getKey()
		]);
	}

	/** @test */
	public function can_be_invited_to_a_private_conversation()
	{
		/** @var Conversation $conversation */
		$conversation = Users::john()->conversations()->create([
			'topic' => 'hello world',
			'requires_invitation' => true
		]);
		$conversation->invite(Users::jane());

		$this->assertDatabaseHas(Models::table('invitation'), [
			'invitee_id' => Users::jane()->getKey(),
			'conversation_id' => $conversation->getKey()
		]);
	}

	/** @test */
	public function can_leave_a_conversation()
	{
		$john = Users::john();

		/** @var Conversation $conversation */
		$conversation = $john->conversations()->create([
			'topic' => 'hello world'
		]);

		$john->leave($conversation);

		$this->assertDatabaseMissing(Models::table('participant'), [
			'user_id' => $john->getKey(),
			'conversation_id' => $conversation->getKey()
		]);
	}

	/** @test */
	public function can_reply_to_a_conversation()
	{
		/** @var Conversation $conversation */
		$conversation = Users::john()->conversations()->create([
			'topic' => 'hello world',
			'requires_invitation' => true
		]);

		Users::john()->reply($conversation, [
			'subject' => 'testing',
			'content' => 'testing'
		])->save();

		$this->assertDatabaseHas(Models::table('reply'), [
			'participant_id' => Users::john()->participants->first()->id,
			'subject' => 'testing',
			'content' => 'testing'
		]);
	}

	/** @test */
	function can_upload_attachments_to_a_reply()
	{
		/** @var Conversation $conversation */
		$conversation = Users::john()->conversations()->create([
			'topic' => 'hello world',
			'requires_invitation' => true
		]);

		$reply = Users::john()->reply($conversation, [
			'subject' => 'testing',
			'content' => 'testing'
		]);

		$reply->saveOrFail();

		/** @var \Sasin91\LaravelConversations\Models\Attachment $attachment */
		$attachment = forward_static_call([Models::instance('attachment'), 'fake']);

		$reply->attachments()->save($attachment);

		$this->assertDatabaseHas(Models::table('attachment'), [
			'attachable_id' => $reply->getKey(),
			'attachable_type' => get_class($reply),
			'name' => $attachment->name,
			'id' => $attachment->getKey()
		]);
	}
}
