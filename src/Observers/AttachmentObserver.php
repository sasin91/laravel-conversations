<?php

namespace Sasin91\LaravelConversations\Observers;

use Illuminate\Support\Facades\Storage;
use Sasin91\LaravelConversations\Config\Icons;
use Sasin91\LaravelConversations\Jobs\TrashUploadedFile;

class AttachmentObserver
{
	public function updating($model)
	{
		if ($model->isDirty('path')) {
			if (config('conversable.queue')) {
				TrashUploadedFile::dispatch($model->getOriginal('path'));
			} else {
				Storage::delete($model->getOriginal('path'));
			}
		}
	}

	public function deleting($model)
	{
		if (config('conversable.queue')) {
			TrashUploadedFile::dispatch($model->path);
		} else {
			Storage::delete($model->path);
		}
	}
	
	public function saving($model)
	{
		if (! isset($model->icon)) {
			$model->setAttribute('icon', Icons::forAttachment($model));
		}
	}

	public function saved($model)
	{
		if (! isset($model->download_link)) {
			$model->update(['download_link'  => $model->link()]);
		}
	}
}