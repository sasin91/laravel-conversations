<?php

namespace Sasin91\LaravelConversations\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Sasin91\LaravelConversations\Config\Models;

class CreateAttachmentsTable extends Migration
{
	public function up()
	{
		Schema::create(Models::table('attachment'), function (Blueprint $table) {
			$table->increments('id');
			
			$table->morphs('attachable');

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
		Schema::drop(Models::table('attachment'));
	}
}