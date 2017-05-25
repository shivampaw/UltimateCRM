<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewProject extends Mailable
{
    protected $client;
    protected $project;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
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
        return $this->view('emails.projects.new')
                    ->with('client', $this->client)
                    ->with('project', $this->project)
                    ->to($this->client->email, $this->client->name)
                    ->attachData(Storage::get($this->project->pdf_path), 'project.pdf')
                    ->subject('['.$this->client->name.'] New Project Created');
    }
}
