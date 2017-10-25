<?php

namespace Sasin91\LaravelConversations\Observers;


class ReadableObserver
{
	public function creating($readable)
	{
		if (!isset($readable->read_at)) {
			$readable->read_at = $readable->freshTimestamp();
		}
	}
}
