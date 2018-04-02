<?php

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Money\Currencies\ISOCurrencies;
use Money\Parser\DecimalMoneyParser;

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
    $invoiceItem = [
        'description' => $faker->sentence(),
        'quantity'    => $faker->numberBetween(1, 10),
        'price'       => $faker->randomFloat(2, 50, 500),
    ];
    $invoice_items = json_encode([$invoiceItem]);

    $total = $invoiceItem['quantity'] * $invoiceItem['price'];

    $currencies = new ISOCurrencies();
    $moneyParser = new DecimalMoneyParser($currencies);
    $money = $moneyParser->parse((string) $total, config('crm.currency'));

    $total = $money->getAmount();

    return [
        'client_id'    => create(Client::class)->id,
        'due_date'     => Carbon::tomorrow(),
        'total'        => $total,
        'item_details' => $invoice_items,
        'project_id'   => null,
    ];
});

$factory->define(Project::class, function (Faker\Generator $faker) {
    $file = UploadedFile::fake()->create('project.pdf', 200);
    $path = Storage::put('public/project_files', $file);

    return [
        'title'     => $faker->sentence(),
        'client_id' => create(Client::class)->id,
        'pdf_path'  => $path,
    ];
});
