<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoicePaid extends Mailable
{
    protected $client;

    protected $invoice;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param $client
     * @param $invoice
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
        return $this->view('emails.invoices.paid')
                    ->with('client', $this->client)
                    ->with('invoice', $this->invoice)
                    ->subject('[' . $this->client->name . '] Invoice #' . $this->invoice->id . ' Has Been Paid For')
                    ->to($this->client->email, $this->client->name);
    }
}
