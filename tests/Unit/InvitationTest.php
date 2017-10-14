<?php

namespace Sasin91\LaravelConversations\Tests\Unit;

use Sasin91\LaravelConversations\Config\Models;
use Sasin91\LaravelConversations\Tests\TestCase;

class InvitationTest extends TestCase
{
	/** @test */
	public function it_generates_a_code_on_creation()
	{
		$this->assertNotNull(factory(Models::name('invitation'))->create()->code, 'Did not create an invitation code.');
	}
}