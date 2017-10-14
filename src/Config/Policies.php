<?php

namespace Sasin91\LaravelConversations\Config;

use Illuminate\Support\Facades\Gate;
use Sasin91\LaravelConversations\Models\Conversation;
use Sasin91\LaravelConversations\Policies\ConversationPolicy;

class Policies extends ConfigDecorator
{
	/**
	 * @inheritdoc
	 */
	public static function swap($key, $value)
	{
		parent::swap($key, $value);

		list($model, $policy) = self::get($key);

		Gate::policy(Models::name($model), $policy);
	}

	/**
	 * Register all model policies.
	 */
	public static function register()
	{
		foreach (array_wrap(static::all()) as $model => $policy) {
			Gate::policy(Models::name($model), $policy);
		}
	}
}