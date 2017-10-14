<?php

namespace Sasin91\LaravelConversations\Models;


interface InvitationCode
{
	public function __invoke($invitation): String;
}