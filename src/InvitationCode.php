<?php

namespace Sasin91\LaravelConversations;


interface InvitationCode
{
	public function __invoke($invitation): String;
}