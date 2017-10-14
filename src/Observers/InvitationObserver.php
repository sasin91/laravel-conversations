<?php

namespace Sasin91\LaravelConversations\Observers;


use Sasin91\LaravelConversations\Models\InvitationCode;

class InvitationObserver
{
	public function creating($invitation)
	{
		$code = resolve(InvitationCode::class);

		$invitation->forceFill(['code' => $code($invitation)]);
	}
}