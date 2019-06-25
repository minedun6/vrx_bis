<?php

use App\Models\Access\Role\Role;
use App\Models\Access\User\User;
use App\Models\Box\Box;
use App\Models\Box\BoxStatus;
use App\Models\Box\Status;
use App\Models\Game\Game;
use App\Models\Worker\Worker;
use App\Models\Location\Location;
use App\Models\Game\GameHistoric;
use Faker\Generator;

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

$factory->define(User::class, function (Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'confirmation_code' => md5(uniqid(mt_rand(), true)),
    ];
});

$factory->state(User::class, 'active', function () {
    return [
        'status' => 1,
    ];
});

$factory->state(User::class, 'inactive', function () {
    return [
        'status' => 0,
    ];
});

$factory->state(User::class, 'confirmed', function () {
    return [
        'confirmed' => 1,
    ];
});

$factory->state(User::class, 'unconfirmed', function () {
    return [
        'confirmed' => 0,
    ];
});

/**
 * Roles
 */
$factory->define(Role::class, function (Generator $faker) {
    return [
        'name' => $faker->name,
        'all' => 0,
        'sort' => $faker->numberBetween(1, 100),
    ];
});

$factory->state(Role::class, 'admin', function () {
    return [
        'all' => 1,
    ];
});

$factory->define(Box::class, function (Generator $faker) {
    return [
        'code' => str_random(8),
        'location_id' => factory(Location::class)->create()->id,
        'box_status' => Status::all()->random()->id,
        'price1' => $faker->numberBetween(1, 30),
        'price2' => $faker->numberBetween(1, 30),
        'price3' => $faker->numberBetween(1, 30),
    ];
});

$factory->define(Worker::class, function (Generator $faker) {
    return [
        'code' => str_random(6),
        'phone1' => $faker->unique()->phoneNumber,
        'phone2' => $faker->unique()->phoneNumber,
        'phone3' => $faker->unique()->phoneNumber,
        'started_at' => $faker->dateTimeBetween($startDate = '-5 years', $endDate = 'now'),
        'user_id' => factory(User::class)->create()->id,
        'default_box' => factory(Box::class)->create()->id
    ];
});

$factory->define(Game::class, function (Generator $faker) {
    return [
        'code' => str_random(6),
        'name' => $faker->unique()->sentence(1),
        'bought_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now'),
        'duration' => $faker->time()
    ];
});

$factory->define(Location::class, function (Generator $faker) {
    return [
        'name' => $faker->address,
        'city' => $faker->city
    ];
});


$factory->define(Status::class, function (Generator $faker) {
    return [
        'label' => $faker->word
    ];
});

$factory->define(GameHistoric::class, function (Generator $faker) {
    $box = Box::all()->random();
    $players_number = $faker->randomElement(['1', '2', '3']);
    $is_paid = $faker->randomElement(['0', '1']);
    if ($is_paid == 1) {
        switch ($players_number) {
            case '1':
                $price = $box->price1;
                break;
            case '2':
                $price = $box->price2;
                break;
            case '3':
                $price = $box->price3;
                break;
            default:
                $price = 0;
                break;
        };
    } else if ($is_paid == 0) {
        $price = 0;
    }

    return [
        'game_id' => Game::all()->random()->id,
        'box_id' => $box->id,
        'worker_id' => Worker::all()->random()->id,
        'played_at' => $faker->dateTimeBetween($startDate = '-1 year', $endDate = '+1 year', $timezone = date_default_timezone_get()),
        'is_payed' => $is_paid,
        'players_number' => $players_number,
        'price' => $price,
        'created_at' => Carbon\Carbon::now(),
        'updated_at' => Carbon\Carbon::now()
    ];
});