<?php

namespace Sasin91\LaravelConversations\Models;


use Illuminate\Database\Eloquent\Model;
use Sasin91\LaravelConversations\Config\Models;

class Reply extends Model
{
	use Concerns\CanBeRead;

	/**
	 * @inheritdoc
	 */
	protected $fillable = ['subject', 'content'];

	/**
	 * A reply is part of a conversation through a participant.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function conversation()
	{
		return $this->belongsTo(
			Models::name('conversation'),
			'conversation_id',
			'id',
			Models::name('participant')
		);
	}

	/**
	 * The participator that replies to the conversation.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function participant()
	{
		return $this->belongsTo(Models::name('participant'));
	}

	/**
	 * Uploaded attachments
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
	 */
	public function attachments()
	{
		return $this->morphToMany(Models::name('attachment'), 'attachable');
	}
}
