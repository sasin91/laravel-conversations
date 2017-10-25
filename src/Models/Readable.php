<?php

namespace Sasin91\LaravelConversations\Models;

use Illuminate\Database\Eloquent\Model;
use Sasin91\LaravelConversations\Config\Models;
use Sasin91\LaravelConversations\Observers\ReadableObserver;

class Readable extends Model
{
	/**
	 * @inheritdoc
	 */
	public $timestamps = false;
	/**
	 * @inheritdoc
	 */
	protected $fillable = ['participant_id', 'readable_id', 'readable_type', 'read_at'];
	/**
	 * @inheritdoc
	 */
	protected $dates = ['read_at'];

	/**
	 * @inheritdoc
	 */
	protected static function boot()
	{
		parent::boot();

		static::observe(new ReadableObserver);
	}

	/**
	 * The participant that is reading the readable model.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function participant()
	{
		return $this->belongsTo(Models::name('participant'));
	}

	/**
	 * The readable model.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
	 */
	public function readable()
	{
		return $this->morphTo();
	}
}
