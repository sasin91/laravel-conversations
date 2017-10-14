<?php

namespace Sasin91\LaravelConversations\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Sasin91\LaravelConversations\Config\Models;
use Sasin91\LaravelConversations\Observers\ConversationObserver;

class Conversation extends Model
{
	use Concerns\CanBeRead,
		Concerns\HasInvites;

	/**
	 * @inheritdoc
	 */
	protected $fillable = ['topic', 'requires_invitation'];

	/**
	 * @inheritdoc
	 */
	protected $casts = ['requires_invitation' => 'boolean'];

	/**
	 * @inheritdoc
	 */
	protected static function boot()
	{
		parent::boot();

		static::observe(new ConversationObserver);

		static::addGlobalScope('withParticipantsCount', function ($query) {
			$query->withCount('participants');
		});

		static::addGlobalScope('withInvitesCount', function ($query) {
			$query->withCount('invitations');
		});
	}

	/**
	 * A conversation has a creator
	 *
	 * @return \Illuminate\Database\Query\Builder|static
	 */
	public function creator()
	{
		return $this->hasOne(Models::name('creator'))
					->oldest();
	}

	/**
	 * There may be many that participate in the conversation.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function participants()
	{
		return $this->hasMany(Models::name('participant'));
	}

	/**
	 * The replies of the participators in the conversation.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
	 */
	public function replies()
	{
		return $this->hasManyThrough(Models::name('reply'), Models::name('participant'));
	}
}