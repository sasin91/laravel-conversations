<?php

namespace Sasin91\LaravelConversations\Policies;

class ReplyAttachmentPolicy extends Policy
{
	public function create()
	{
		return true;
	}

	public function view($user, $attachment)
	{
		return $user->replies
			->map->attachments
			->contains($attachment);
	}

	public function update($user, $attachment)
	{
		return $attachment->attachable
			->participant
			->user->is($user);
	}

	public function destroy($user, $attachment)
	{
		return $attachment->attachable
			->participant
			->user->is($user);
	}
}
