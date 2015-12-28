<?php

use App\Modules\User\Models\User;
use App\Modules\User\Models\Password;
use App\Modules\UserDetails\Models\UserDetails;
use App\Modules\UserRelationship\Models\UserRelationship;
use App\Modules\Message\Models\Message;
use App\Modules\Brand\Models\Brand;
use App\Modules\Rental\Models\Address;
use App\Modules\Message\Models\Media;
use App\Modules\User\Models\Role;
use App\Modules\Action\Models\Action;
use App\Modules\Permission\Models\Permission;
use App\Modules\Rental\Models\Property;
use App\Modules\Rental\Models\PropertyDetail;
use App\Modules\PropertyLog\Models\PropertyLog;
use App\Modules\Rental\Models\Rental;
use App\Modules\Rental\Models\RentalUser;
use App\Modules\AdminAccess\Models\AdminAccess;
use App\Modules\Issue\Models\Issue;
use App\Modules\Issue\Models\IssueDetail;
use App\Modules\Issue\Models\IssueProgress;
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
	    	$array['media_ids'][] = $faker->randomElement(Media::all()->all())->id;
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
    $directory = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' .DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'media';
	if(!file_exists($directory))
		mkdir($directory);
	$file = $faker->image($directory);
	$name = basename($file);
	$mimeType = mime_content_type($file);
	$newPath = (dirname($file) . DIRECTORY_SEPARATOR . sha1(file_get_contents($file)) . (pathinfo($name, PATHINFO_EXTENSION) === '' ? : ('.' . pathinfo($name, PATHINFO_EXTENSION))));
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
    $array = [
        'property_id' => $faker->randomElement(Property::all()->all())->id,
        'type' => $faker->word,
        'carParks' => random_int(0,5) === 0 ? null : random_int(0,3),
        'carParks' => random_int(0,5) === 0 ? null : random_int(0,3),
        'bedrooms' => random_int(0,10) === 0 ? null : random_int(1,5),
        'bathrooms' => random_int(0,10) === 0 ? null : random_int(1,3),
        'options' => [],
    ];
    for($i=0; $i<random_int(0,5); $i++)
    {
        $array['options'][] = [$faker->word => $faker->randomNumber()];
    }
    $array['options'] = json_encode($array['options']);
    return $array;
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
    	$array['media_ids'][] = $faker->randomElement(Media::all()->all())->id;
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

$factory->define(IssueDetail::class, function (Faker\Generator $faker) {
    $array = [
        'issue_id' => $faker->randomElement(Issue::all()->all())->id,
        'content' => $faker->sentences(random_int(1, 200), true),
    	'type' => $faker->words(random_int(1, 2), true),
    	'3rdParty' => $faker->url,
    	'priority' => $faker->numberBetween(0,5),
    	'media_ids' => []
    ];
    
    for($i = 0; $i < random_int(1, 10); $i++)
    	$array['media_ids'][] = $faker->randomElement(Media::all()->all())->id;
    $array['media_ids'] = json_encode($array['media_ids']);
    
    return $array;
});

$factory->define(IssueProgress::class, function (Faker\Generator $faker) {
    return [
        'issue_id' => $faker->randomElement(Issue::all()->all())->id,
        'content' => $faker->sentences(random_int(1, 200), true),
    ];
});

$factory->define(RentalUser::class, function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->randomElement(User::all()->all())->id,
        'role_id' => $faker->randomElement(Role::all()->all())->id,
        'rental_id' => $faker->randomElement(Rental::all()->all())->id,
    ];
});


