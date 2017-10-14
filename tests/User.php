<?php

namespace Sasin91\LaravelConversations\Tests;

use Illuminate\Database\Eloquent\Model;
use Sasin91\LaravelConversations\Conversable;

class User extends Model
{
	use Conversable;

	protected $connection = 'testbench';

	protected $fillable = ['email'];
}