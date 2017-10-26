<?php

use Sasin91\LaravelConversations\Config\Models;
use Sasin91\LaravelConversations\Tests\User;

$factory->define(User::class, function ($faker) {
	return ['email' => $faker->safeEmail];
});

$factory->define(Models::name('conversation'), function ($faker) {
	return [
		'topic' => $faker->paragraph
	];
});

$factory->define(Models::name('participant'), function ($faker) {
	return [
		'conversation_id' => factory(Models::name('conversation'))->lazy(),
		'user_id' => factory(Models::name('user'))->lazy(),

		'is_moderator' => false,
		'is_creator' => false,

		'banned_at' => null,
		'ban_reason' => null
	];
});

$factory->state(Models::name('participant'), 'moderator', function () {
	return ['is_moderator' => true];
});

$factory->state(Models::name('participant'), 'creator', function () {
	return ['is_creator' => true];
});

$factory->state(Models::name('participant'), 'banned', function () {
	static $reason, $date;

	return [
		'banned_at' => $date,
		'ban_reason' => $reason
	];
});

$factory->define(Models::name('invitation'), function () {
	return [
		'conversation_id' => factory(Models::name('conversation'))->lazy(),
		'invitee_id' => factory(Models::name('user'))->lazy()
	];
});
