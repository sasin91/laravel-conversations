<?php

namespace Sasin91\LaravelConversations\Policies;

class InvitationPolicy extends Policy
{
	public function create()
	{
		return true;
	}

	public function view($user, $invitation)
	{
		return $user->invitations->contains($invitation);
	}

	public function update($user, $invitation)
	{
		return $invitation->creator->is($user);
	}

	public function delete($user, $invitation)
	{
		return $invitation->creator->is($user)
			|| $invitation->invitee->is($user);
	}
}
