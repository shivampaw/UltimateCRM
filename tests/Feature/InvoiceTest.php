<?php

namespace Tests\Feature;

use App\Mail\NewInvoice;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use DatabaseMigrations;

    protected $client;

    protected $admin;

    public function setUp()
    {
        parent::setUp();
        $this->admin = create(User::class, [
            'is_admin' => 1,
        ]);
    }

    /** @test */
    public function admins_can_create_and_delete_invoices()
    {
        $client = create(Client::class);
        $invoiceItems = [
            [
                'description' => 'Test invoice item',
                'quantity'    => 4,
                'price'       => 302.20,
            ],
        ];

        Mail::fake();

        $this->signIn($this->admin)
             ->post('/clients/' . $client->id . '/invoices', [
                 'due_date'     => Carbon::tomorrow(),
                 'invoiceItems' => $invoiceItems,
             ]);

        Mail::assertSent(NewInvoice::class, function ($mail) use ($client) {
            return $mail->hasTo($client->email);
        });

        $invoice = $client->invoices()->first();
        $this->assertDatabaseHas('invoices', $invoice->toArray());

        $this->delete('/clients/' . $client->id . '/invoices/' . $invoice->id);
        $this->assertDatabaseMissing('invoices', $invoice->toArray());
    }

    /** @test */
    public function clients_can_view_their_invoices()
    {
        $invoice = create(Invoice::class);

        $this->signIn($invoice->client->user)
             ->get('/invoices/')
             ->assertSee("Invoice #" . $invoice->id)
             ->assertStatus(200);
    }

    /** @test */
    public function clients_can_view_a_single_invoice()
    {
        $invoice = create(Invoice::class);

        $this->signIn($invoice->client->user)
             ->get('/invoices/' . $invoice->id)
             ->assertSee("Invoice #" . $invoice->id)
             ->assertSee($invoice->client->name)
             ->assertStatus(200);
    }

    /** @test */
    public function admins_can_view_all_client_invoices()
    {
        $invoice = create(Invoice::class);
        $client = $invoice->client;

        $this->signIn($this->admin)
             ->get('/clients/' . $client->id . '/invoices/')
             ->assertSee("Invoice #" . $invoice->id)
             ->assertStatus(200);
    }

    /** @test */
    public function admins_can_view_a_single_client_invoice()
    {
        $invoice = create(Invoice::class);
        $client = $invoice->client;

        $this->signIn($this->admin)
             ->get('/clients/' . $client->id . '/invoices/' . $invoice->id)
             ->assertSee("Invoice #" . $invoice->id)
             ->assertSee($client->name)
             ->assertStatus(200);
    }
}