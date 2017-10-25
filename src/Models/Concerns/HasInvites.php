<?php

namespace Sasin91\LaravelConversations\Models\Concerns;

use Sasin91\LaravelConversations\Config\Models;

trait HasInvites
{
	/**
	 * Determine if the conversation requires an invitation
	 *
	 * @return bool
	 */
	public function isPublic()
	{
		return !$this->requires_invitation;
	}

	/**
	 * Invite given User to participate in the conversation.
	 *
	 * @param \Illuminate\Database\Eloquent\Model $user
	 *
	 * @return \Sasin91\LaravelConversations\Models\Invitation | \Illuminate\Database\Eloquent\Model
	 */
	public function invite($user)
	{
		return $this->invitations()->create([
			'invitee_id' => $user->getKey()
		]);
	}

	/**
	 * Invitations sent for the conversation.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function invitations()
	{
		return $this->hasMany(Models::name('invitation'), 'conversation_id');
	}
}
