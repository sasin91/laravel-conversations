<?php

namespace Sasin91\LaravelConversations\Policies;

class ConversationPolicy extends Policy
{
	public function create()
	{
		return true;
	}

	public function view($user, $conversation)
	{
		return $user->conversations->contains($conversation);
	}

	public function update($user, $conversation)
	{
		return $conversation->creator->user->is($user);
	}

	public function delete($user, $conversation)
	{
		return $conversation->creator->user->is($user);
	}
}
