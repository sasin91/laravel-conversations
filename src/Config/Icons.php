<?php

namespace Sasin91\LaravelConversations\Config;

class Icons extends ConfigDecorator
{
	/**
	 * @param \Sasin91\LaravelConversations\Models\Attachment $attachment
	 *
	 * @return string
	 */
	public static function forAttachment($attachment)
	{
		return static::forMime($attachment->mime_type);
	}

	/**
	 * @param string $mime
	 *
	 * @return string
	 */
	public static function forMime($mime)
	{
		return self::get($mime, 'default');
	}

	/**
	 * @param \Illuminate\Http\File $file
	 *
	 * @return string
	 */
	public static function forFile($file)
	{
		return static::forMime($file->getMimeType());
	}
}
