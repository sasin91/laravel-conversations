<?php

namespace Sasin91\LaravelConversations\Policies;

class ParticipantPolicy extends Policy
{
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

	public function destroy($user, $participant)
	{
		return $participant->user->is($user);
	}
}
