<?php

namespace Sasin91\LaravelConversations\Policies;


use Sasin91\LaravelConversations\Config\Policies;

abstract class Policy
{
	public function before()
	{
		return value(Policies::value('callbacks.before', true));
	}

	public function after()
	{
		return value(Policies::value('callbacks.after', true));
	}
}