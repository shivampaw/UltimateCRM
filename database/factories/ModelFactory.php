<?php

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\RecurringInvoice;
use App\Models\User;
use App\Services\RecurringInvoiceService;
use Brick\Money\Money;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('password'),
        'is_admin' => false,
        'remember_token' => str_random(10),
    ];
});

$factory->define(Client::class, function (Faker\Generator $faker) {
    $user = create(User::class);

    return [
        'name' => $user->name,
        'user_id' => $user->id,
        'email' => $user->email,
        'number' => $faker->phoneNumber,
        'address' => $faker->address,
    ];
});

$factory->define(Invoice::class, function (Faker\Generator $faker) {
    $invoiceItem = [
        'description' => $faker->sentence(),
        'quantity' => $faker->numberBetween(1, 10),
        'price' => $faker->randomFloat(2, 10, 50),
    ];

    $discount = $faker->randomFloat(2, 0, 10);
    $total = 0 - $discount;

    $discount = getMinorUnit($discount);

    $total += $invoiceItem['quantity'] * $invoiceItem['price'];
    $invoiceItem['price'] = getMinorUnit($invoiceItem['price']);

    $invoice_items = json_encode([$invoiceItem]);

    $due_date = $faker->dateTimeBetween($startDate = '-10 days', $endDate = '+2 weeks');
    $create_project = rand(0, 1) == 1;

    $client_id = null;
    $project_id = null;

    if ($create_project) {
        $project = create(Project::class);
        $client_id = $project->client->id;
        $project_id = $project->id;
    }

    return [
        'client_id' => $client_id ?? create(Client::class)->id,
        'project_id' => $project_id ?? null,
        'discount' => $discount,
        'due_date' => $due_date,
        'total' => Money::of($total, config('crm.currency'))->getMinorAmount()->toInt(),
        'item_details' => $invoice_items,
        'overdue_notification_sent' => Carbon::parse($due_date->format('Y-m-d'))->isPast() ? true : false
    ];
});

$factory->define(Project::class, function (Faker\Generator $faker) {
    $path = "http://www.pdf995.com/samples/pdf.pdf";

    return [
        'title' => $faker->sentence(),
        'client_id' => create(Client::class)->id,
        'pdf_path' => $path,
    ];
});

$factory->define(RecurringInvoice::class, function (Faker\Generator $faker) {
    $data = [
        'how_often' => $faker->randomElement(['Every month', 'Every day', 'Every week', 'Every two weeks']),
        'next_run' => $faker->dateTimeBetween('today', '+3 days')->setTime(0, 0),
        'due_date' => $faker->numberBetween(1, 14),
        'discount' => $faker->randomFloat(2, 0, 10),
        'item_details' => [
            [
                'description' => $faker->sentence(),
                'quantity' => $faker->numberBetween(1, 10),
                'price' => $faker->randomFloat(2, 10, 50)
            ]
        ],
    ];

    $data = app(RecurringInvoiceService::class)->getRecurringInvoiceData($data);
    $data['client_id'] = create(Client::class)->id;

    return $data;
});
