<?php

use App\Models\User;
use App\Models\Client;

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
        'email'          => $faker->safeEmail,
        'password'       => bcrypt(str_random(10)),
        'is_admin'		 => false,
        'remember_token' => str_random(10),
    ];
});

$factory->define(Client::class, function(Faker\Generator $faker) {
	$user = factory(User::class)->create();
	return [
		'name'			=> $faker->name,
		'user_id'		=> $user->id,
		'email'			=> $user->email,
		'number'		=> $faker->phoneNumber,
		'address'		=> $faker->address,
	];
});