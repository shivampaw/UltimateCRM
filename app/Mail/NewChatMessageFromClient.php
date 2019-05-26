<?php

namespace App\Mail;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewChatMessageFromClient extends Mailable
{
    use Queueable, SerializesModels;

    public $chat;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.chats.from_client')
            ->subject('[' . $this->chat->project->client->name . '] Project ' . $this->chat->project->title . ' Has Had A Chat Added')
            ->to(User::where('is_admin', true)->get());
    }
}
