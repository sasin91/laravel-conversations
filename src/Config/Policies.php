<?php

namespace Sasin91\LaravelConversations\Config;

use Illuminate\Support\Facades\Gate;

class Policies extends ConfigDecorator
{
	/**
	 * A callback that runs before any authorization methods are invoked.
	 *
	 * @var \Closure | null
	 */
	protected static $beforeCallback;

	/**
	 * A callback that runs after a policy has authorized a given action.
	 *
	 * @var \Closure | null
	 */
	protected static $afterCallback;

	/**
	 * Get the Policy::before callback.
	 *
	 * @return \Closure|null
	 */
	public static function getBeforeCallback()
	{
		return static::$beforeCallback;
	}

	/**
	 * Get the Policy::after callback.
	 *
	 * @return \Closure|null
	 */
	public static function getAfterCallback()
	{
		return static::$afterCallback;
	}

	/**
	 * Register a Policy::before callback.
	 *
	 * @param \Closure $callback
	 */
	public static function before(\Closure $callback)
	{
		static::$beforeCallback = $callback;
	}

	/**
	 * Register a Policy::after callback.
	 *
	 * @param \Closure $callback
	 */
	public static function after(\Closure $callback)
	{
		static::$afterCallback = $callback;
	}

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
		return collect(static::all())->mapWithKeys(function ($policy, $model) {
			return [Models::name($model) ?? $model => $policy];
		})->toArray();
	}
}
