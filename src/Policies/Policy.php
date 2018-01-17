<?php

namespace Sasin91\LaravelConversations\Policies;

use Sasin91\LaravelConversations\Config\Policies;

abstract class Policy
{
	public function before($user, $ability)
	{
		$before = Policies::getBeforeCallback();

		if (is_null($before)) {
			return true;
		}

		return $before($user, $ability);
	}

	public function after($user, $ability)
	{
		$after = Policies::getAfterCallback();

		if (is_null($after)) {
			return true;
		}

		return $after($user, $ability);
	}
}
