<?php

namespace Sasin91\LaravelConversations\Tests\Migrations;


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->increments('id');

			$table->string('email');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('users');
	}
}