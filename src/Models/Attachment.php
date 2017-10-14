<?php

namespace Sasin91\LaravelConversations\Models;


use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Sasin91\LaravelConversations\Config\Models;
use Sasin91\LaravelConversations\Observers\AttachmentObserver;

class Attachment extends Model
{
	protected $fillable = ['name', 'mime_type', 'hash_name', 'download_link', 'path', 'icon', 'compressed', 'uploaded_at'];

	protected $dates = ['uploaded_at'];

	protected static function boot()
	{
		parent::boot();

		static::observe(new AttachmentObserver);
	}

	/**
	 * Upload given file as an attachment.
	 *
	 * @param UploadedFile $file
	 * @param string|null $name
	 * @return static
	 */
	public static function upload($file, $name = null)
	{
		return tap(new static, function ($instance) use($file, $name) {
			$instance->fill([
				'name'          => $name ?? $file->getClientOriginalName(),
				'path'          => $file->store('attachments'),
				'hash_name'     => $file->hashName(),
				'mime_type'     => $file->getMimeType(),
				'uploaded_at'   => $instance->freshTimestamp()
			]);
		});
	}

	/**
	 * Attachment::uploaded() scope
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 */
	public function scopeUploaded($query)
	{
		$query->whereNotNull('uploaded_at');
	}

	/**
	 * Attachment relation
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
	 */
	public function attachable()
	{
		return $this->morphTo();
	}

	/**
	 * Dynamically get the storage_path attribute.
	 *
	 * @return string
	 */
	public function getStoragePathAttribute()
	{
		return storage_path("app/{$this->path}");
	}

	/**
	 * Attachment download link
	 *
	 * @return string
	 */
	public function link()
	{
		return "/download-attachment/{$this->id}";
	}

	/**
	 * Download the uploaded file.
	 *
	 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function download()
	{
		return $this->downloadThrough(response());
	}

	/**
	 * @param ResponseFactory $response
	 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function downloadThrough($response)
	{
		return $response->download($this->storage_path);
	}
}