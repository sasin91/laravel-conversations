<?php return [

	'queue' =>  'conversations',

	'disk'  =>  'conversations',

	'icons' =>  [
		'default'           =>  'file-o',
		'image/png'         =>  'file-image-o',
		'image/jpeg'        =>  'file-image-o',
		'image/gif'         =>  'file-image-o',
		'application/pdf'   =>  'file-pdf-o'
	],

	'policies'  =>  [
		'callbacks' =>  [
			'before'    =>  null,
			'after'     =>  null,
		],

		'conversation'  =>  'Sasin91\LaravelConversations\Policies\ConversationPolicy',
		'invitation'    =>  'Sasin91\LaravelConversations\Policies\InvitationPolicy'
	],

	'models' => [
		'user' 		=>	'App\User',
		'invitation'    =>  'Sasin91\LaravelConversations\Models\Invitation',
		'conversation' 	=> 	'Sasin91\LaravelConversations\Models\Conversation',
		'participant'	=>	'Sasin91\LaravelConversations\Models\Participant',
		'creator'       =>  'Sasin91\LaravelConversations\Models\Creator',
		'reply'		=>	'Sasin91\LaravelConversations\Models\Reply',
		'attachment'	=>	'Sasin91\LaravelConversations\Models\Attachment',
		'reads'  =>  'Sasin91\LaravelConversations\Models\Readable'
	]
];