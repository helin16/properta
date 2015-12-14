<?php

use App\Modules\User\Models\User;
use App\Modules\Password\Models\Password;
use App\Modules\UserDetails\Models\UserDetails;
use App\Modules\UserRelationship\Models\UserRelationship;
use App\Modules\Message\Models\Message;
use App\Modules\Brand\Models\Brand;
use App\Modules\Address\Models\Address;
use App\Modules\Media\Models\Media;
use App\Modules\Role\Models\Role;
use App\Modules\Action\Models\Action;
use App\Modules\Permission\Models\Permission;
use App\Modules\Property\Models\Property;
use App\Modules\PropertyDetail\Models\PropertyDetail;
use App\Modules\PropertyLog\Models\PropertyLog;
use App\Modules\Rental\Models\Rental;
use App\Modules\AdminAccess\Models\AdminAccess;
use App\Modules\Issue\Models\Issue;
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
    $array = [
        'from_user_id' => ($from_user_id = $faker->randomElement(User::all()->all())->id),
        'to_user_id' => $faker->randomElement(User::where('id', '!=', $from_user_id)->get()->all())->id,
        'subject' => $faker->sentence,
        'content' => $faker->sentences(random_int(3,100), true),
        'media_ids' => []
    ];
    if(Address::all()->count() > 0)
	    for($i = 0; $i < random_int(1, 10); $i++)
	    	$array['media_ids'][] = $faker->randomElement(Address::all()->all())->id;
	$array['media_ids'] = json_encode($array['media_ids']);
    return $array;
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
	$newPath = (DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . sha1(file_get_contents($file)) . (pathinfo($name, PATHINFO_EXTENSION) === '' ? : ('.' . pathinfo($name, PATHINFO_EXTENSION))));
	if($file !== $newPath)
		rename($file, $newPath);
    return [
        'mimeType' => $mimeType,
        'name' => $name,
        'path' => $newPath
    ];
});

$factory->define(Role::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->words(random_int(1, 3), true),
        'description' => $faker->sentences(random_int(1, 5), true)
    ];
});

$factory->define(Action::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->words(random_int(1, 3), true),
        'description' => $faker->sentences(random_int(1, 5), true)
    ];
});

$factory->define(Permission::class, function (Faker\Generator $faker) {
	do
	{
	    $array = [
	        'action_id' => $faker->randomElement(Action::all()->all())->id,
	        'role_id' => $faker->randomElement(Role::all()->all())->id,
	    	'permitted' => $faker->boolean(80)
	    ];
	} while(Permission::where(['action_id' => $array['action_id'], 'role_id' => $array['role_id']])->get()->count() > 0);
    return $array;
});

$factory->define(Property::class, function (Faker\Generator $faker) {
    return [
        'address_id' => $faker->randomElement(Address::all()->all())->id,
        'description' => $faker->sentences(random_int(1, 20), true)
    ];
});

$factory->define(PropertyDetail::class, function (Faker\Generator $faker) {
    return [
        'property_id' => $faker->randomElement(Property::all()->all())->id,
        'type' => $faker->word,
        'carParks' => $faker->numberBetween(0,2),
        'bedrooms' => $faker->numberBetween(0,5),
        'bathrooms' => $faker->numberBetween(1,3),
        'options' => json_encode([])
    ];
});

$factory->define(PropertyLog::class, function (Faker\Generator $faker) {
    return [
        'property_id' => $faker->randomElement(Property::all()->all())->id,
        'type' => $faker->word,
        'content' => $faker->sentences(random_int(1, 20), true),
        'comments' => json_encode([])
    ];
});

$factory->define(Rental::class, function (Faker\Generator $faker) {
    $array = [
        'property_id' => $faker->randomElement(Property::all()->all())->id,
    	'dailyAmount' => $faker->randomFloat(4, 500/30, 2000/30),
        'from' => random_int(0, 1) === 0 ? null : $faker->dateTimeBetween('-10 years'),
        'to' => random_int(0, 1) === 0 ? null : $faker->dateTimeBetween('now', '+10 years'),
    	'media_ids' => []
    ];
    
    for($i = 0; $i < random_int(1, 10); $i++)
    	$array['media_ids'][] = $faker->randomElement(Address::all()->all())->id;
    $array['media_ids'] = json_encode($array['media_ids']);
	    
    return $array;
});

$factory->define(AdminAccess::class, function (Faker\Generator $faker) {
	do
	{
	    $array = [
	        'rental_id' => $faker->randomElement(Rental::all()->all())->id,
	        'role_id' => $faker->randomElement(Role::all()->all())->id,
	    	'canManage' => $faker->boolean(),
	    	'canManage' => $faker->boolean(),
	    	'canIssue' => $faker->boolean(),
	    	'canDocument' => $faker->boolean(),
	    	'canStatement' => $faker->boolean(),
	    	'canMessage' => $faker->boolean(),
	    ];
    } while(AdminAccess::where(['rental_id' => $array['rental_id'], 'role_id' => $array['role_id']])->get()->count() > 0);
    return $array;
});

$factory->define(Issue::class, function (Faker\Generator $faker) {
    return [
        'requester_user_id' => $faker->randomElement(User::all()->all())->id,
        'rental_id' => $faker->randomElement(Rental::all()->all())->id,
    	'status' => $faker->words(random_int(1, 2), true),
    ];
});
