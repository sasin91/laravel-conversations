<?php

namespace Sasin91\LaravelConversations\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TrashUploadedFile implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	public $path;

	public function __construct($path)
	{
		$this->path = $path;
		$this->onQueue($this->queue());
	}

	public function queue()
	{
		$queue = value(config('conversable.queue'));

		return (string)$queue;
	}

	public function handle(Storage $storage)
	{
		$storage->disk(config('conversable.disk'))->delete($this->path);
	}
}
