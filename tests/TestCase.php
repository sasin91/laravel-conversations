<?php

namespace Sasin91\LaravelConversations\Tests;

require __DIR__ . '/../migrations/create_conversable_tables.php';

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Database\Eloquent\Model;
use Orchestra\Testbench\TestCase as TestbenchTestCase;
use Sasin91\LaravelConversations\Config\Models;
use Sasin91\LaravelConversations\ConversableServiceProvider;

abstract class TestCase extends TestbenchTestCase
{
	protected function setUp()
	{
		parent::setUp();

		$this->app->bind(EloquentFactory::class, function ($app) {
			return EloquentFactory::construct(Faker::create(), __DIR__.'/Factories');
		});

		//Event::fake();

		if (in_array(Databases::class, class_uses(static::class))) {
			$this->setupDatabases();
		}
	}

	protected function getPackageProviders($app)
	{
		return [ConversableServiceProvider::class];
	}

	protected function getPackageAliases($app)
	{
		return [
			//
		];
	}

	/**
	 * Define environment setup.
	 *
	 * @param  \Illuminate\Foundation\Application
	 * @return void
	 */
	protected function getEnvironmentSetUp($app)
	{
		// Setup default database to use sqlite :memory:
		$app['config']->set('database.default', 'testbench');
		$app['config']->set('database.connections.testbench', [
			'driver'   => 'sqlite',
			'database' => ':memory:',
			'prefix'   => '',
		]);

		$app['config']->set('conversable', include(__DIR__.'/../config/conversable.php'));

		Models::swap('user', 'Sasin91\LaravelConversations\Tests\User');
	}

	/**
	 * Determine if given model's database has been deleted.
	 *
	 * @param Model $model
	 * @return bool
	 */
	protected function assertModelDeleted($model): bool
	{
		if (! $model->exists) {
			return true;
		}

		$this->assertDatabaseMissing($model->getTable(), [$model->getKeyName() => $model->getKey()]);
	}
}
