<?php

namespace Sasin91\LaravelConversations\Policies;

use Sasin91\LaravelConversations\Config\Policies;

abstract class Policy
{
	public function before($user, $ability)
	{
		return Policies::value('callbacks.before', [$user, $ability], true);
	}

	public function after($user, $ability)
	{
		return Policies::value('callbacks.before', [$user, $ability], true);
	}
}
