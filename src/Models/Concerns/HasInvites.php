<?php

namespace Sasin91\LaravelConversations\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Sasin91\LaravelConversations\Models\Invitation;

trait HasInvites
{
	/**
	 * Determine if the converation requires an invitation
	 *
	 * @return bool
	 */
	public function isPublic()
	{
		return ! $this->requires_invitation;
	}

	/**
	 * Invite given User to participate in the conversation.
	 *
	 * @param Model $user
	 * @return Invitation | Model
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
		return $this->hasMany(Invitation::class, 'conversation_id');
	}
}