<?php

namespace Sasin91\LaravelConversations\Tests\Fixtures;


use Illuminate\Database\Eloquent\Model;
use Sasin91\LaravelConversations\Tests\User;

class Users
{
	static $john;

	static $jane;

	/**
	 * @return User | Model
	 */
	public static function john()
	{
		if (static::$john) {
			return static::$john;
		}

		return static::$john = User::firstOrCreate(['email' => 'john@example.com']);
	}

	/**
	 * @return User | Model
	 */
	public static function jane()
	{
		if (static::$jane) {
			return static::$jane;
		}

		return static::$jane = User::firstOrCreate(['email' => 'jane@example.com']);
	}
}