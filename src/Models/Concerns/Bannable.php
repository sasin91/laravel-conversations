<?php

namespace Sasin91\LaravelConversations\Models\Concerns;

trait Bannable
{
	public function scopeBanned($query)
	{
		$query->whereNotNull('banned_at');
	}

	public function isBanned()
	{
		return !is_null($this->banned_at);
	}

	public function ban($reason = null, $timestamp = null)
	{
		return tap($this)->update([
			'banned_at' => $timestamp ?? $this->freshTimestamp(),
			'ban_reason' => $reason
		]);
	}

	public function sanction($cleanSlate = true)
	{
		return tap($this)->update([
			'banned_at' => null,
			'ban_reason' => $cleanSlate ? null : $this->ban_reason
		]);
	}
}
