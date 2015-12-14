<?php

use App\Modules\User\Models\User;
use App\Modules\Password\Models\Password;
use App\Modules\UserDetails\Models\UserDetails;
use App\Modules\UserRelationship\Models\UserRelationship;
use App\Modules\Message\Models\Message;
use App\Modules\Brand\Models\Brand;
use App\Modules\Address\Models\Address;
use App\Modules\Media\Models\Media;
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
        'email' => $faker->email,
    ];
});

$factory->define(Password::class, function (Faker\Generator $faker) {
    return [
        'password' => Hash::make(str_random(15))
    ];
});

$factory->define(UserDetails::class, function (Faker\Generator $faker) {
    $array =  [
        'firstName' => $faker->firstName,
        'lastName' => $faker->lastName,
        'contactNumber' => $faker->phoneNumber
    ];
    if(random_int(0,1) === 0)
        $array['emergencyContact'] = $faker->phoneNumber;
    return $array;
});

$factory->define(UserRelationship::class, function (Faker\Generator $faker) {
    return [
        'parent_user_id' => $faker->randomElement(User::all()->all())->id
    ];
});

$factory->define(Message::class, function (Faker\Generator $faker) {
    return [
        'from_user_id' => ($from_user_id = $faker->randomElement(User::all()->all())->id),
        'to_user_id' => $faker->randomElement(User::where('id', '!=', $from_user_id)->get()->all())->id,
        'subject' => $faker->sentence,
        'content' => $faker->sentences(random_int(3,100), true),
        'media_ids' => json_encode([])
    ];
});

$factory->define(Brand::class, function (Faker\Generator $faker) {
    return [
        'address_id' => $faker->randomElement(Address::all()->all())->id,
        'settings' => json_encode([])
    ];
});

$factory->define(Address::class, function (Faker\Generator $faker) {
    return [
        'street' => $faker->streetAddress,
        'suburb' => $faker->city,
        'state' => $faker->city,
        'country' => $faker->country,
        'postcode' => $faker->postcode
    ];
});

$factory->define(Media::class, function (Faker\Generator $faker) {
	if(!file_exists('/tmp'))
		mkdir('/tmp');
	$file = $faker->image(DIRECTORY_SEPARATOR . 'tmp');
	$name = basename($file);
	$mimeType = mime_content_type($file);
	rename($file, $newPath = (DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . sha1(file_get_contents($file)) . '.' . pathinfo($name, PATHINFO_EXTENSION)));
    return [
        'mimeType' => $mimeType,
        'name' => $name,
        'path' => $newPath
    ];
});

