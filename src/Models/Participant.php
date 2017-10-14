<?php

namespace Sasin91\LaravelConversations\Models;

use Illuminate\Database\Eloquent\Model;
use Sasin91\LaravelConversations\Config\Models;

class Participant extends Model
{
	use Concerns\Bannable;

	/**
	 * @inheritdoc
	 */
	protected $fillable = [
		'conversation_id',
		'user_id',
		'banned_at',
		'ban_reason',
		'is_moderator'
	];

	/**
	 * @inheritdoc
	 */
	protected $dates = ['banned_at'];

	/**
	 * @inheritdoc
	 */
	protected $casts = ['is_moderator' => 'boolean'];

	/**
	 * The conversation we're participating in.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function conversation()
	{
		return $this->belongsTo(Models::name('conversation'));
	}

	/**
	 * A Participant belongs to a user.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo(Models::name('user'));
	}

	/**
	 * The participants replies.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function replies() 
	{
		return $this->hasMany(Models::name('reply'));
	}

	/**
	 * The readable's the participant has read.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function reads()
	{
		return $this->hasMany(Models::name('reads'));
	}
}