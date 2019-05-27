<?php

namespace Tests\Feature;

use App\Mail\NewChatMessageFromAdmin;
use App\Mail\NewChatMessageFromClient;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ChatTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->admin = create(User::class, ['is_admin' => true]);
        $this->project = $project = create(Project::class);
    }

    /** @test */
    public function admin_can_leave_chat_message()
    {
        Mail::fake();

        $this->signIn($this->admin)
            ->post('/projects/1/chats', ['message' => 'Hello!'])
            ->assertRedirect('/clients/1/projects/1#project_chat');

        Mail::assertSent(NewChatMessageFromAdmin::class, function (Mailable $mail) {
            $mail->build();
            return $mail->hasTo($this->project->client->email);
        });
    }

    /** @test */
    public function client_can_leave_chat_message()
    {
        Mail::fake();

        $this->signIn($this->project->client->user)
            ->post('/projects/1/chats', ['message' => 'Hello!'])
            ->assertRedirect('/projects/1#project_chat');

        Mail::assertSent(NewChatMessageFromClient::class, function (Mailable $mail) {
            $mail->build();
            return $mail->hasTo(User::where('is_admin', true)->get());
        });
    }
}
