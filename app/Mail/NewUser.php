<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUser extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    protected $password;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @param $password
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
        return $this->view('emails.users.' . strtolower(($this->user->is_admin) ? 'Admin' : 'Client'))
            ->with([
                'user' => $this->user,
                'password' => $this->password,
                'login_url' => $this->getLoginUrl()
            ])
            ->subject('[' . $this->user->name . '] Your New ' . ($this->user->is_admin ? 'Admin' : 'Client') . ' Account')
            ->to($this->user);
    }

    private function getLoginUrl()
    {
        return signedLoginUrl($this->user->id);
    }
}
