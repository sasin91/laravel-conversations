<?php

namespace Sasin91\LaravelConversations\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Sasin91\LaravelConversations\Config\Models;

class CreateConversationParticipantsTable extends Migration
{
	public function up()
	{
		Schema::create(Models::table('participant'), function (Blueprint $table) {
			$conversation = Models::instance('conversation');
			$user = Models::instance('user');

			$table->increments('id');

			$table->boolean('is_creator')->default(false);
			
			$table->unsignedInteger($conversation->getForeignKey())->index();
			$table->foreign($conversation->getForeignKey())
				  ->references($user->getKeyName())
				  ->on($conversation->getTable());

			$table->unsignedInteger($user->getForeignKey())->index();
			$table->foreign($user->getForeignKey())
				  ->references($user->getKeyName())
				  ->on($user->getTable());

			$table->timestamp('banned_at')->nullable();
			$table->string('ban_reason')->nullable();

			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop(Models::table('participant'));
	}
}