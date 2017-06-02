<?php

use App\Models\Client;
use App\Models\Invoice;
use App\Models\User;
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
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => bcrypt('secret'),
        'is_admin'       => false,
        'remember_token' => str_random(10),
    ];
});

$factory->define(Client::class, function (Faker\Generator $faker) {
    $user = create(User::class);

    return [
        'name'    => $faker->name,
        'user_id' => $user->id,
        'email'   => $user->email,
        'number'  => $faker->phoneNumber,
        'address' => $faker->address,
    ];
});

$factory->define(Invoice::class, function (Faker\Generator $faker) {
    $client = create(Client::class);

    $invoiceItem = array(
        "description" => $faker->sentence(3),
        "quantity"    => $faker->randomDigit,
        "price"       => $faker->randomFloat(2, 50, 500),

    );

    $invoice_items = json_encode([
        $invoiceItem,
    ]);

    $total = $invoiceItem['quantity'] * $invoiceItem['price'];

    return [
        'client_id'    => $client->id,
        'due_date'     => Carbon::tomorrow(),
        'total'        => $total,
        'item_details' => $invoice_items,
    ];
});
