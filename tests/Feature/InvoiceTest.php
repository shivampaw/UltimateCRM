<?php

namespace Tests\Feature;

use App\Mail\InvoicePaid;
use App\Mail\NewInvoice;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Stripe\Charge;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

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
        $item_details = [
            [
                'description' => 'Test Invoice Item',
                'quantity' => 4,
                'price' => 302.20,
            ],
        ];

        Mail::fake();

        $this->signIn($this->admin)
            ->post('/clients/' . $client->id . '/invoices', [
                'due_date' => Carbon::tomorrow(),
                'item_details' => $item_details,
                'notes' => 'Lorem Ipsum.',
                'discount' => 10.00
            ]);

        $this->get('/clients/1/invoices/1')
            ->assertSee('Lorem Ipsum.')
            ->assertSee('Test Invoice Item')
            ->assertSee('4')
            ->assertSee('GBP 302.20')
            ->assertSee('GBP 1208.80')
            ->assertSee('GBP 10.00')
            ->assertSee('GBP 1198.80')
            ->assertSee(Carbon::tomorrow()->toFormattedDateString());

        Mail::assertSent(NewInvoice::class, function (NewInvoice $mail) use ($client) {
            $mail->build();
            return $mail->hasTo($client->email);
        });

        /** @var Invoice $invoice */
        $invoice = $client->invoices()->first();
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

    /** @test */
    public function client_can_pay_invoice()
    {
        $invoice = create(Invoice::class);

        Mail::fake();

        $this->signIn($invoice->client->user)
            ->followingRedirects()
            ->post('/invoices/1', ['stripeToken' => 'tok_visa'])
            ->assertSee('Invoice Paid!');

        Mail::assertSent(InvoicePaid::class, function (InvoicePaid $mail) use ($invoice) {
            $mail->build();
            return $mail->hasTo($invoice->client->email);
        });

        $invoice->refresh();

        $this->assertNotNull($invoice->stripe_charge_id);
        $this->assertEquals($invoice->total, Charge::retrieve($invoice->stripe_charge_id)->amount);
        $this->assertEquals(1, $invoice->paid);
    }

    /** @test */
    public function invalid_stripetoken_fails_payment()
    {
        $invoice = create(Invoice::class);

        $this->signIn($invoice->client->user)
            ->followingRedirects()
            ->post('/invoices/1', ['stripeToken' => 'tok_chargeDeclined'])
            ->assertSee('Your card was declined.');

        $this->assertNull($invoice->stripe_charge_id);
        $this->assertNull($invoice->paid);
    }
}
