<?php

namespace Sasin91\LaravelConversations\Models;


use Illuminate\Database\Eloquent\Model;
use Sasin91\LaravelConversations\Config\Models;
use Sasin91\LaravelConversations\Observers\InvitationObserver;

class Invitation extends Model
{
	/**
	 * @inheritdoc
	 */
	protected $fillable = ['conversation_id', 'invitee_id', 'expires_at', 'code'];

	/**
	 * @inheritdoc
	 */
	protected $dates = ['expires_at'];

	/**
	 * @inheritdoc
	 */
	protected $dispatchesEvents = [
		'accepted' => 'Sasin91\LaravelConversations\Events\InvitationAccepted',
		'declined' => 'Sasin91\LaravelConversations\Events\InvitationDeclined',
	];

	/**
	 * @inheritdoc
	 */
	protected static function boot()
	{
		parent::boot();

		static::observe(new InvitationObserver);
	}

	/**
	 * An invite grants permission to enter a private conversation.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function conversation()
	{
		return $this->belongsTo(Models::name('conversation'), 'conversation_id');
	}

	/**
	 * The creator of the invite.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function creator()
	{
		return $this->belongsTo(
			Models::name('user'),
			'creator_id',
			'id',
			Models::name('conversation')
		);
	}

	/**
	 * The owner of the invitation.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function invitee()
	{
		return $this->belongsTo(Models::name('user'), 'invitee_id');
	}

	/**
	 * Accept the invitation and attend the conversation.
	 *
	 * @return Conversation
	 */
	public function accept()
	{
		return tap($this->invitee->attend($this->conversation), function () {
			$this->fireModelEvent('accepted');

			$this->delete();
		});
	}

	/**
	 * Decline & scrap the invitation.
	 *
	 * @return void
	 */
	public function decline()
	{
		$this->fireModelEvent('declined');

		$this->delete();
	}
}