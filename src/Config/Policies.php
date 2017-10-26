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

	/**
	 * Register all model policies.
	 */
	public static function register()
	{
		foreach (static::registrable() as $model => $policy) {
			Gate::policy($model, $policy);
		}
	}

	/**
	 * Get the registrable policies.
	 *
	 * @return array
	 */
	public static function registrable()
	{
		return collect(static::all())->filter(function ($value, $key) {
			$exclude = ['callbacks'];

			return !in_array($key, $exclude);
		})->mapWithKeys(function ($policy, $model) {
			return [Models::name($model) ?? $model => $policy];
		})->toArray();
	}
}
