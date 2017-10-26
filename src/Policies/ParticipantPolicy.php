<?php

namespace Sasin91\LaravelConversations\Policies;

class ParticipantPolicy extends Policy
{
	public function create()
	{
		return true;
	}

	public function view($user, $participant)
	{
		return $user->conversations
			->map->participants
			->contains($participant);
	}

	public function update($user, $participant)
	{
		return $participant->user->is($user);
	}

	public function delete($user, $participant)
	{
		return $participant->user->is($user);
	}
}
