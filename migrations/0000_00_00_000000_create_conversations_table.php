<?php

namespace Sasin91\LaravelConversations\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Sasin91\LaravelConversations\Config\Models;

class CreateConversationsTable extends Migration
{
	public function up()
	{
		Schema::create(Models::table('conversation'), function (Blueprint $table) {
			$table->increments('id');

			$table->string('topic');
			$table->boolean('requires_invitation')->default(false);

			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop(Models::table('conversation'));
	}
}