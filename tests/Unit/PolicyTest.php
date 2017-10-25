<?php

namespace Sasin91\LaravelConversations\Tests\Unit;

use Sasin91\LaravelConversations\Config\Policies;
use Sasin91\LaravelConversations\Tests\TestCase;

/**
 * Class PolicyTest
 *
 * @package \\${NAMESPACE}
 */
class PolicyTest extends TestCase
{
	/** @test */
	function it_lists_all_policies_without_callbacks()
	{
		$this->app['config']->set('conversable.policies', ['testing' => '1234', 'callbacks' => []]);

		self::assertEquals(['testing' => '1234'], Policies::all());
	}

	/** @test */
	function it_can_get_the_callbacks()
	{
		$this->app['config']->set('conversable.policies.callbacks', ['before' => 'yay', 'after' => 'nay']);

		self::assertEquals(['before' => 'yay', 'after' => 'nay'], Policies::get('callbacks'));
	}

	/** @test */
	function it_executes_a_before_callback()
	{
		config([
			'conversable.policies.callbacks.before' => function ($value) {
				self::assertEquals('test-value', $value);
			}
		]);

		Policies::value('callbacks.before', ['test-value'], true);
	}

	/** @test */
	function it_executes_a_after_callback()
	{
		config([
			'conversable.policies.callbacks.after' => function ($value) {
				self::assertEquals('test-value', $value);
			}
		]);

		Policies::value('callbacks.after', ['test-value'], true);
	}
}
