<?php

namespace Sasin91\LaravelConversations;

use Illuminate\Support\ServiceProvider;
use Sasin91\LaravelConversations\Config\Policies;
use Sasin91\LaravelConversations\Models\InvitationCode;

class ConversableServiceProvider extends ServiceProvider
{
	public function boot()
	{
		//
	}

	public function register()
	{
		Policies::register();

		$this->app->singleton(InvitationCode::class, function () {
			return function () {
				return str_random();
			};
		});
	}
}