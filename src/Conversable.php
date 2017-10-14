<?php

namespace Sasin91\LaravelConversations;

use Illuminate\Database\Eloquent\Collection as DatabaseCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Sasin91\LaravelConversations\Config\Models;
use Sasin91\LaravelConversations\Models\Conversation;
use Sasin91\LaravelConversations\Models\Participant;
use Sasin91\LaravelConversations\Models\Readable;
use Sasin91\LaravelConversations\Models\Reply;
use Sasin91\LaravelConversations\Tests\User;

trait Conversable
{
	/**
	 * A Conversable can send Invitations to conversations they own.
	 *
	 * @return HasMany
	 */
	public function sentInvitations()
	{
		return $this->hasMany(Models::name('invitation'), 'creator_id');
	}

	/**
	 * A Conversable can receive Invitations to conversations.
	 *
	 * @return HasMany
	 */
	public function receivedInvitations()
	{
		return $this->hasMany(Models::name('invitation'), 'invitee_id');
	}

	/**
	 * Get all conversations through participant(s).
	 *
	 * @return BelongsToMany
	 */
	public function conversations()
	{
		$conversation = Models::instance('conversation');

		return $this->belongsToMany(
			Models::name('conversation'),
			Models::table('participant'),
			$this->getForeignKey(),
			$conversation->getForeignKey(),
			$this->getKeyName(),
			$conversation->getKeyName(),
			Models::name('participant')
		);
	}

	/**
	 * A Conversable can have many Conversation replies.
	 *
	 * @return HasManyThrough
	 */
	public function replies()
	{
		return $this->hasManyThrough(Models::name('reply'), Models::name('conversation'));
	}

	/**
	 * A Conversable can participate in many Conversations.
	 *
	 * @return HasMany
	 */
	public function participants()
	{
		return $this->hasMany(Models::name('participant'));
	}

	/**
	 * Reply to a conversation.
	 *
	 * @param Conversation  $conversation
	 * @param array         $attributes
	 * @return Reply
	 */
	public function reply($conversation, $attributes = [])
	{
		return tap(reply($attributes), function ($reply) use($conversation) {
			$reply->participant()->associate(
				$this->participants()->firstOrCreate([
					$conversation->getForeignKey() => $conversation->getKey()
				])
			);
		});
	}

	/**
	 * Get all the Conversations we are attending with given model.
	 *
	 * @param User | Participant    $other
	 * @return DatabaseCollection
	 */
	public function attendingWith($other)
	{
		return $this->conversations()->withoutGlobalScopes()->whereHas('participants', function ($query) use($other) {
			$user = Models::user();
			if ($other instanceof $user) {
				return $query->where($other->getForeignKey(), '=', $other->getKey());
			}

			return $query->where(Models::participant()->getKeyName(), '=', $other->getKey());
		})->get();
	}

	/**
	 * Attend given Conversation.
	 *
	 * @param Conversation $conversation
	 * @return Conversation
	 */
	public function attend($conversation)
	{
		return tap($conversation, function ($conversation) {
			$this->conversations()->attach($conversation);
		});
	}

	/**
	 * Leave given Conversation.
	 *
	 * @param Conversation $conversation
	 * @return void
	 */
	public function leave($conversation)
	{
		$this->conversations()->detach($conversation);
	}

	/**
	 * Determine if the Conversable has read given conversation.
	 *
	 * @param Conversation $conversation
	 * @return boolean
	 */
	public function hasRead($conversation)
	{
		return Readable::whereIn(Models::foreignKey('participant'), $this->participants->pluck('id'))
						->where(function ($query) use($conversation) {
							$query->where('readable_type', get_class($conversation))
								  ->where('readable_id', $conversation->getKey());
						})
						->exists();
	}

	/**
	 * Mark given conversation as read.
	 *
	 * @param Conversation          $conversation
	 * @param Participant | null    $participant
	 *
	 * @return Readable|Model
	 */
	public function markAsRead($conversation, $participant = null)
	{
		$participant = $participant ?? $this->participants
											->where($conversation->getForeignKey(), $conversation->getKey())
											->first();

		return $conversation->readers()->create([
			'read_at' 						=>	$read_at ?? $this->freshTimestamp(),
			$participant->getForeignKey()	=>	$participant->getKey()
		]);
	}
}