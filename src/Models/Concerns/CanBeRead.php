<?php

namespace Sasin91\LaravelConversations\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Sasin91\LaravelConversations\Config\Models;
use Sasin91\LaravelConversations\Models\Participant;

trait CanBeRead
{
	/**
	 * Scoop the conversations read by a Participant or User.
	 *
	 * @param Model $participantOrUser
	 *
	 * @return Builder
	 */
	public static function readBy($participantOrUser)
	{
		$participant = Models::name('participant');

		if ($participantOrUser instanceof $participant) {
			return static::readByParticipant($participantOrUser);
		}

		return static::readByUser($participantOrUser);
	}

	/**
	 * Scoop the conversations read by a given participant.
	 *
	 * @param Builder $query
	 * @param Model   $participant
	 *
	 * @return void
	 */
	public function scopeReadByParticipant($query, $participant)
	{
		$query->whereHas('readers.participant', function ($query) use ($participant) {
			$query->where($participant->getForeignKey(), $participant->getKey());
		});
	}

	/**
	 * Scoop the conversations read by a given user.
	 *
	 * @param Builder $query
	 * @param Model   $user
	 *
	 * @return void
	 */
	public function scopeReadByUser($query, $user)
	{
		$query->whereHas('readers.participant.user', function ($query) use ($user) {
			$query->where($user->getForeignKey(), $user->getKey());
		});
	}

	/**
	 * Determine if the conversation has been read by given participant.
	 *
	 * @param Participant $participant
	 *
	 * @return boolean
	 */
	public function hasBeenReadBy($participant)
	{
		return $this->readers->filter(function ($readable) use ($participant) {
			return $readable->participant->is($participant);
		})->isNotEmpty();
	}

	/**
	 * Mark the conversation as read by given participant.
	 *
	 * @param Participant    $participant
	 * @param null|\DateTime $read_at
	 *
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function markAsReadBy($participant, $read_at = null)
	{
		return $this->readers()->create([
			'read_at' => $read_at ?? $this->freshTimestamp(),
			$participant->getForeignKey() => $participant->getKey()
		]);
	}

	/**
	 * A Conversation can have many readers.
	 *
	 * @return MorphMany
	 */
	public function readers()
	{
		return $this->morphMany(Models::name('reads'), 'readable')
			->whereIn('participant_id', $this->participants->pluck('id'))
			->latest();
	}
}
