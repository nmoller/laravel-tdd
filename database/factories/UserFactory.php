<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Concert::class, function (Faker $faker) {
    static $password;

    return [
      'title' => 'Example Band',
      'subtitle' => 'with The Fake Openers',
      'date' => Carbon::parse('+2 weeks' , 'America/Toronto'),
      'ticket_price' => 3250,
      'venue' => 'The Example Theater',
      'venue_address' => '123 Example Lane',
      'city' => 'Fakeville',
      'state' => 'ON',
      'zip' => '90210',
      'additional_information' => 'Some sample additional information.'
    ];
});
