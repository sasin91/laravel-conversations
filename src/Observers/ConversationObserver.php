<?php

namespace Sasin91\LaravelConversations\Observers;

use Sasin91\LaravelConversations\Models\Conversation;

class ConversationObserver
{
	/**
	 * @param Conversation $conversation
	 */
	public function saving($conversation)
	{
		if (is_null($conversation->creator)) {
			$creator = $conversation->participants()->first();

			if ($creator && $conversation->creator()->save($creator)) {
				$creator->forceFill(['is_creator' => true])->save();

				$conversation->setRelation('creator', $creator);
			}
		}

		if ($conversation->invitations->isNotEmpty()) {
			$conversation->requires_invitation = true;
		}
	}

	/**
	 * Delete all participants just before the conversation.
	 *
	 * @param $conversation
	 */
	public function deleting($conversation)
	{
		$conversation->participants->each->delete();
	}
}
