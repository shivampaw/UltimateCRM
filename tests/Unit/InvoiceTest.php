<?php

namespace Tests\Unit;

use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function invoices_belongs_to_a_client()
    {
        $invoice = create(Invoice::class);
        $this->assertInstanceOf(Client::class, $invoice->client);
    }
}
