<?php

namespace Sasin91\LaravelConversations\Models\Concerns;

use Illuminate\Support\Str;

trait InheritsParentTable
{
	/**
	 * Get the table associated with the model.
	 *
	 * @return string
	 */
	public function getTable()
	{
		if (!isset($this->table)) {
			return str_replace('\\', '', Str::snake(Str::plural(class_basename(new parent))));
		}

		return $this->table;
	}
}
