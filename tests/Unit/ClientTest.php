<?php

namespace Tests\Unit;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function client_has_a_user()
    {
        $client = create(Client::class);
        $this->assertInstanceOf(User::class, $client->user);
    }

    /** @test */
    public function client_has_many_invoices()
    {
        $client = create(Client::class);

        create(Invoice::class, [
            'client_id' => $client->id,
        ], 2);

        $this->assertEquals(2, $client->invoices->count());
    }
}
