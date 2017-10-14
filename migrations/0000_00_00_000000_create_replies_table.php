<?php

namespace Sasin91\LaravelConversations\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Sasin91\LaravelConversations\Config\Models;

class CreateConversationRepliesTable extends Migration
{
	public function up()
	{
		Schema::create(Models::table('reply'), function (Blueprint $table) {
			$participant = Models::instance('participant');

			$table->increments('id');

			$table->unsignedInteger($participant->getForeignKey())->index();
			$table->foreign($participant->getForeignKey())
			          ->references($participant->getKeyName())
			          ->on($participant->getTable())
			          ->onDelete('cascade')
			          ->onUpdate('cascade');

			$table->string('subject');
			$table->text('content');

			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('replies');
	}
}