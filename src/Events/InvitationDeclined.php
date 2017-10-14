<?php

namespace Sasin91\LaravelConversations\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvitationDeclined
{
	use Dispatchable, SerializesModels, InteractsWithSockets;

	public $invitation;

	public function __construct($invitation)
	{
		$this->invitation = $invitation;
	}
}