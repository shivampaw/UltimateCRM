<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Mail\NewChatMessageFromAdmin;
use App\Mail\NewChatMessageFromClient;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ChatController extends Controller
{
    public function store(Project $project, Request $request)
    {
        $data = $this->validate($request, [
            'message' => 'required',
            'attachment' => 'file|mimes:jpeg,bmp,png,pdf,gif,jpg,docx,xlsx,doc,xls'
        ]);

        $data['from_admin'] = Auth::user()->is_admin;
        $data['user_id'] = Auth::id();

        if (!empty($data['attachment'])) {
            $data['attachment'] = $request->attachment->store('public/chats');
        }

        $chat = $project->chats()->create($data);

        if (Auth::user()->is_admin) {
            Mail::send(new NewChatMessageFromAdmin($chat));
            return redirect('/clients/' . $project->client_id . '/projects/' . $project->id . '#project_chat');
        }
        Mail::send(new NewChatMessageFromClient($chat));
        return redirect('/projects/' . $project->id . '#project_chat');
    }
}
