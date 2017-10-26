<?php

namespace Sasin91\LaravelConversations\Policies;

class ReplyPolicy extends Policy
{
	public function create()
	{
		return true;
	}

	public function view($user, $reply)
	{
		return $user->replies->contains($reply);
	}

	public function update($user, $reply)
	{
		return $reply->participant->user->is($user);
	}

	public function delete($user, $reply)
	{
		return $reply->participant->user->is($user);
	}
}
