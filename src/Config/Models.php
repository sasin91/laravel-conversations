<?php

namespace Sasin91\LaravelConversations\Config;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Database\Eloquent\Model;

class Models extends ConfigDecorator
{
	/**
	 * Create a factory or model instance.
	 *
	 * @param string $model
	 * @param array $attributes
	 * @return Model|Factory
	 */
	public static function fake($model, $attributes = [])
	{
		return tap(factory(static::name($model)), function (&$factory) use($attributes) {
			if (! empty($attributes)) {
				$factory = $factory->create($attributes);
			}
		});
	}

	/**
	 * Get the table for a given model.
	 *
	 * @param string $model
	 * @return string
	 */
	public static function table($model)
	{
		return static::instance($model)->getTable();
	}

	/**
	 * get the foreign key of given model.
	 *
	 * @param string $model
	 * @return string
	 */
	public static function foreignKey($model)
	{
		return static::instance($model)->getForeignKey();
	}

	/**
	 * Get the primary key name of given model.
	 *
	 * @param string $model
	 * @return string
	 */
	public static function keyName($model)
	{
		return self::instance($model)->getKeyName();
	}
}