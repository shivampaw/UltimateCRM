<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProjectAccepted extends Mailable
{
    protected $client;

    protected $project;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param $client
     * @param $project
     */
    public function __construct($client, $project)
    {
        $this->client = $client;
        $this->project = $project;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (User::where('id', 1)->exists()) {
            $superAdmin = User::find(1);
            $this->cc($superAdmin->email, $superAdmin->name);
        }

        return $this->view('emails.projects.accepted')->with('client', $this->client)->with('project', $this->project)->subject('['.$this->client->name.'] '.$this->project->title.' Has Been Accepted')->attachData(Storage::get($this->project->pdf_path), 'project.pdf')->to($this->client->email, $this->client->name);
    }
}
