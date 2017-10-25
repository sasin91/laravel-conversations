<?php

namespace Sasin91\LaravelConversations;

use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;
use Sasin91\LaravelConversations\Config\Policies;

class ConversableServiceProvider extends ServiceProvider
{
	public function boot()
	{
		$timestamp = Carbon::now()->format('Y_m_d_His');

		$this->publishes([
			__DIR__ . '/../migrations/create_conversable_tables.php' => database_path("migrations/{$timestamp}_create_conversable_tables.php")
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
