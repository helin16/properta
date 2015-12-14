<?php

use App\Modules\User\Models\user;
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

$factory->define(App\Modules\User\Models\user::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->email,
    ];
});

// $factory->define(App\password::class, function (Faker\Generator $faker) {
//     return [
//         'password' => Hash::make(str_random(15))
//     ];
// });

// $factory->define(App\userDetails::class, function (Faker\Generator $faker) {
//     $array =  [
//         'firstName' => $faker->firstName,
//         'lastName' => $faker->lastName,
//         'contactNumber' => $faker->phoneNumber
//     ];
//     if(random_int(0,1) === 0)
//         $array['emergencyContact'] = $faker->phoneNumber;
//     return $array;
// });

// $factory->define(App\userRelationships::class, function (Faker\Generator $faker) {
//     return [
//         'parent_user_id' => $faker->randomElement(App\user::all()->all())->id
//     ];
// });

// $factory->define(App\messages::class, function (Faker\Generator $faker) {
//     return [
//         'from_user_id' => ($from_user_id = $faker->randomElement(App\user::all()->all())->id),
//         'to_user_id' => $faker->randomElement(App\user::where('id', '!=', $from_user_id)->get()->all())->id,
//         'subject' => $faker->sentence,
//         'content' => $faker->sentences(random_int(3,100), true),
//         'media_ids' => json_encode([])
//     ];
// });

