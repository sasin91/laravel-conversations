<?php

namespace Sasin91\LaravelConversations\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Sasin91\LaravelConversations\Config\Models;

class CreateInvitationsTable extends Migration
{
	public function up()
	{
		Schema::create('invitations', function (Blueprint $table) {
			$table->increments('id');

			$table->unsignedInteger(Models::foreignKey('conversation'))->index();
			$table->foreign(Models::foreignKey('conversation'))
				->references(Models::keyName('conversation'))
				->on(Models::table('conversation'));

			$table->unsignedInteger('invitee_id')->index();
			$table->foreign('invitee_id')
				  ->references(Models::keyName('user'))
				  ->on(Models::table('user'));

			$table->string('code');

			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('invitations');
	}
}