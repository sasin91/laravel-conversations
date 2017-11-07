<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Sasin91\LaravelConversations\Config\Models;

/**
 * Class CreateConversableTables
 *
 * @package \Sasin91\LaravelConversations\Migrations
 */
class CreateConversableTables extends Migration
{
	public function up()
	{
		Schema::create(Models::table('conversation'), function (Blueprint $table) {
			$table->increments('id');

			$table->string('topic');
			$table->boolean('requires_invitation')->default(false);

			$table->timestamps();
		});
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
		Schema::create(Models::table('reads'), function (Blueprint $table) {
			$participant = Models::participant();

			$table->increments('id');

			$table->morphs('readable');

			$table->unsignedInteger($participant->getForeignKey())->index();
			$table->foreign($participant->getForeignKey())
				->references($participant->getKeyName())
				->on($participant->getTable())
				->onDelete('cascade')
				->onUpdate('cascade');

			$table->timestamp('read_at');
		});

		Schema::create(Models::table('invitation'), function (Blueprint $table) {
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
		Schema::create(Models::table('attachment'), function (Blueprint $table) {
			$table->increments('id');

			$table->nullableMorphs('attachable');

			$table->string('name');
			$table->string('path');
			$table->string('icon')->default('fa-file-o');
			$table->boolean('compressed')->default(false);

			$table->string('hash_name')->nullable();
			$table->string('mime_type')->nullable();
			$table->string('download_link')->nullable();

			$table->timestamp('uploaded_at')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop(Models::table('conversation'));
		Schema::drop(Models::table('participant'));
		Schema::drop(Models::table('reply'));
		Schema::drop(Models::table('reads'));
		Schema::drop(Models::table('invitation'));
		Schema::drop(Models::table('attachment'));
	}
}
