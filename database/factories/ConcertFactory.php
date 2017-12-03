<?php
/**
 * Created by PhpStorm.
 * User: nmoller
 * Date: 02/12/17
 * Time: 3:31 PM
 */

use Faker\Generator as Faker;
use Carbon\Carbon;

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

$factory->state(App\Concert::class, 'published', function (Faker $faker){
    return [
      'published_at' => Carbon::parse('-1 week')
    ];
});

$factory->state(App\Concert::class, 'unpublished', function (Faker $faker){
    return [
        'published_at' => null
    ];
});