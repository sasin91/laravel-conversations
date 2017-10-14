<?php

if (! function_exists('conversation')) {
	/**
	 * Get the full class name of the Conversation model,
	 * or a new instance of it.
	 * 
	 * @return string | object
	 */
	function conversation() 
	{
		return \Sasin91\LaravelConversations\Config\Models::instance('conversation', ...func_get_args());
	}
}

if (! function_exists('participant')) {
	/**
	 * Get the full class name of the Participant model,
	 * or a new instance of it.
	 *
	 * @return string | object
	 */
	function participant()
	{
		return \Sasin91\LaravelConversations\Config\Models::instance('participant', ...func_get_args());
	}
}

if (! function_exists('creator')) {
	/**
	 * Get the full class name of the Participant model,
	 * or a new instance of it.
	 *
	 * @return string | object
	 */
	function creator()
	{
		return \Sasin91\LaravelConversations\Config\Models::instance('creator', ...func_get_args());
	}
}

if (! function_exists('moderator')) {
	/**
	 * Get the full class name of the Participant model,
	 * or a new instance of it.
	 *
	 * @return string | object
	 */
	function moderator()
	{
		return \Sasin91\LaravelConversations\Config\Models::instance('moderator', ...func_get_args());
	}
}

if (! function_exists('reply')) {
	/**
	 * Get the full class name of the Reply model,
	 * or a new instance of it.
	 *
	 * @return string | object
	 */
	function reply()
	{
		return \Sasin91\LaravelConversations\Config\Models::instance('reply', ...func_get_args());
	}
}

if (! function_exists('attachment')) {
	/**
	 * Get the full class name of the Attachment model,
	 * or a new instance of it.
	 *
	 * @return string | object
	 */
	function attachment()
	{
		return \Sasin91\LaravelConversations\Config\Models::instance('attachment', ...func_get_args());
	}
}