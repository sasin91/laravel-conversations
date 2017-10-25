<?php

namespace Sasin91\LaravelConversations\Config;

use Illuminate\Support\Facades\Gate;

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

	/** @inheritdoc */
	public static function all()
	{
		return array_filter(array_wrap(parent::all()), function ($value, $key) {
			$exclude = ['callbacks'];

			return !in_array($key, $exclude);
		}, ARRAY_FILTER_USE_BOTH);
	}

	/**
	 * Register all model policies.
	 */
	public static function register()
	{
		foreach (static::all() as $model => $policy) {
			Gate::policy(Models::name($model), $policy);
		}
	}
}
