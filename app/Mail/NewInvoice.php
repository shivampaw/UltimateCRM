<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewInvoice extends Mailable
{
    protected $client;
    protected $invoice;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($client, $invoice)
    {
        $this->client = $client;
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.invoices.new')
                    ->with('client', $this->client)
                    ->with('invoice', $this->invoice)
                    ->to($this->client->email, $this->client->name)
                    ->subject('['.$this->client->name.'] New Invoice Generated');

    }
}
