<?php

namespace Sasin91\LaravelConversations\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Sasin91\LaravelConversations\Config\Models;

class CreateReadablesTable extends Migration
{
	public function up()
	{
		Schema::create('readables', function (Blueprint $table) {
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
	}

	public function down()
	{
		Schema::drop('readables');
	}
}