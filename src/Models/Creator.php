<?php

namespace Sasin91\LaravelConversations\Models;

class Creator extends Participant
{
	use Concerns\InheritsParentTable;

	protected static function boot()
	{
		parent::boot();

		static::addGlobalScope('creator', function ($query) {
			$query->where('is_creator', true);
		});

		static::saving(function ($model) {
			$model->forceFill(['is_creator' => true]);
		});
	}
}