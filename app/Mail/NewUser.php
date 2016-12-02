<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewUser extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    protected $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.users.'.strtolower(($this->user->is_admin) ? 'Admin' : 'Client'))
                    ->with('user', $this->user)
                    ->with('password', $this->password)
                    ->to($this->user->email, $this->user->name)
                    ->subject('['.$this->user->name.'] Your New '.($this->user->is_admin ? 'Admin' : 'Client').' Account');
    }
}
