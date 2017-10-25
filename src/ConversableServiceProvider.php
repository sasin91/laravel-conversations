<?php

namespace Sasin91\LaravelConversations;

use Illuminate\Support\ServiceProvider;
use Sasin91\LaravelConversations\Config\Policies;

class ConversableServiceProvider extends ServiceProvider
{
	public function boot()
	{
		$this->publishes([
			__DIR__ . '/../migrations' => database_path('migrations')
		], 'Migrations');

		$this->publishes([
			__DIR__ . '/../config/conversable.php' => config_path('conversable.php')
		], 'Config');
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
