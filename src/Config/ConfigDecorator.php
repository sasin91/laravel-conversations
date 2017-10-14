<?php

namespace Sasin91\LaravelConversations\Config;


use Illuminate\Support\Str;

abstract class ConfigDecorator
{
	/**
	 * get the config key.
	 *
	 * @param string|null $path
	 * @return string
	 */
	protected static function config($path = null)
	{
		$base = self::baseConfig();

		$result =  $base ? "{$base}.{$path}" : $base;

		return Str::lower($result);
	}

	/**
	 * Get the base config path
	 *
	 * @return string
	 */
	protected static function baseConfig()
	{
		$type = class_basename(new static);

		return "conversable.{$type}";
	}

	/**
	 * Dynamically get an instance.
	 *
	 * @param string    $value
	 * @param array     $attributes
	 * @return object
	 */
	public static function __callStatic($value, $attributes = [])
	{
		return static::instance($value, $attributes);
	}

	/**
	 * Temporarily swap a configured value.
	 *
	 * @param string            $value
	 * @param string|callable   $replacement
	 */
	public static function swap($value, $replacement)
	{
		if (config()->has($value = self::config($value))) {
			config()->set($value, $replacement);
		}
	}

	/**
	 * Get all the config values.
	 *
	 * @return mixed
	 */
	public static function all()
	{
		return static::get();
	}
	
	/**
	 * Get the value of the config value.
	 *
	 * @param string|null $value
	 * @param string|null $default
	 * @return string | mixed
	 */
	public static function get($value = null, $default = null)
	{
		return config()->get(value(self::config($value)), $default);
	}

	/**
	 * Get the value of a config value.
	 *
	 * @param string    $value
	 * @param mixed     $default
	 * @return mixed
	 */
	public static function value($value, $default = null)
	{
		return value(self::get($value, $default));
	}

	/**
	 * Get an instance.
	 *
	 * @param string $value
	 * @param array $attributes
	 * @return object
	 */
	public static function instance($value, $attributes = [])
	{
		$class = static::name($value);

		return new $class($attributes);
	}

	/**
	 * Expand the fully qualified name of a given value.
	 *
	 * @param string $value
	 * @return string
	 */
	public static function name($value)
	{
		$value = static::get($value);

		return is_object($value)
			? get_class($value)
			: $value;
	}
}