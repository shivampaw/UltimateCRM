<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $project->chats()->create($data);

        if (Auth::user()->is_admin) {
            return redirect('/clients/' . $project->client_id . '/projects/' . $project->id . '#project_chat');
        }
        return redirect('/projects/' . $project->id . '#project_chat');
    }
}
