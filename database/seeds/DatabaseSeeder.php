<?php

use App\Models\Client;
use App\Models\Invoice;
use App\Models\RecurringInvoice;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app(UserService::class)->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password',
            'is_admin' => true
        ]);

        create(Invoice::class, [
            'paid' => true,
            'paid_at' => Carbon::now(),
            'stripe_charge_id' => 'test_charge'
        ], 3);

        create(Invoice::class, [
            'client_id' => create(Client::class)->id
        ], 2);

        create(RecurringInvoice::class, [], 2);
    }
}
