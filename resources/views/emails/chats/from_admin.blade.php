<p>Hi {{ $chat->project->client->name }},</p>
<p>A chat message has just been added to your project entitled <strong>{{ $chat->project->title }}</strong>.</p>
<p>You can view this chat by logging on at <strong>{!! url('/') !!}</strong>.</p>
<p>The chat message was by {{ $chat->user->name }}.</p>
<p>If you have any questions or problems be sure to email me, you can do so by replying to this email.</p>
<p>Thanks!<br/>
    {{ DB::table('users')->find(1)->name }}
</p>