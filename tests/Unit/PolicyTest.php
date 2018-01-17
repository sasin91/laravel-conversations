<?php

namespace Sasin91\LaravelConversations\Tests\Unit;

use Illuminate\Support\Facades\Gate;
use Sasin91\LaravelConversations\Config\Policies;
use Sasin91\LaravelConversations\Tests\TestCase;
use Sasin91\LaravelConversations\Tests\TestPolicy;

/**
 * Class PolicyTest
 *
 * @package Sasin91\LaravelConversations\Tests\Unit
 */
class PolicyTest extends TestCase
{
	/** @test */
	function it_lists_registrable_policies_without_callbacks()
	{
		$this->app['config']->set('conversable.policies', ['testing' => '1234']);

		self::assertEquals(['testing' => '1234'], Policies::registrable());
	}

	/** @test */
	function it_executes_a_before_callback()
	{
		Policies::before(function ($user, $ability) {
			self::assertNull($user);
			self::assertEquals('test-value', $ability);
		});

		(new TestPolicy)->before(null, 'test-value');
	}

	/** @test */
	function it_executes_a_after_callback()
	{
		Policies::after(function ($user, $ability) {
			self::assertNull($user);
			self::assertEquals('test-value', $ability);
		});

		(new TestPolicy)->after(null, 'test-value');
	}

	/** @test */
	function it_correctly_registers_policies()
	{
		Policies::register();

		$reflection = new \ReflectionClass($gate = Gate::getFacadeRoot());
		$policies = $reflection->getProperty('policies');
		$policies->setAccessible(true);

		$this->assertEquals(Policies::registrable(), $policies->getValue($gate));
	}
}
