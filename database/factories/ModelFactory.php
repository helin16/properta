<?php
use Faker\Generator;
use App\Modules\System\Models\User;
use App\Modules\System\Models\Credential;
use App\Modules\MoneyPool\Models\Group;
use App\Modules\MoneyPool\Models\Group_User;
use App\Modules\System\Models\Role;
/*
 * |--------------------------------------------------------------------------
 * | Model Factories
 * |--------------------------------------------------------------------------
 * |
 * | Here you may define all of your model factories. Model factories give
 * | you a convenient way to create models for testing and seeding your
 * | database. Just tell the factory how a default model should look.
 * |
 */
$factory->define ( User::class, function (Generator $faker) {
	return [
		'active' => intval(random_int(0,10) !== 0),
		'created' => $faker->dateTime,
		'updated' => $faker->dateTime,
		'created_by' => User::all()->count() > 0 ? $faker->randomElement(User::all()->all())->id : 1,
		'updated_by' => User::all()->count() > 0 ? $faker->randomElement(User::all()->all())->id : 1,
		'firstname' => $faker->firstName,
		'lastname' => $faker->lastName,
		'email' => $faker->email
	];
} );
$factory->define ( Credential::class, function (Faker\Generator $faker) {
	return [
		'user_id' => $faker->randomElement(User::all()->all())->id,
		'type' => $faker->randomElement(Credential::getCredentialTypes()),
		'username' => $faker->userName,
		'password' => Hash::make('12345678'),
		'active' => intval(random_int(0,10) !== 0),
		'created' => $faker->dateTime,
		'updated' => $faker->dateTime,
		'created_by' => User::all()->count() > 0 ? $faker->randomElement(User::all()->all())->id : 1,
		'updated_by' => User::all()->count() > 0 ? $faker->randomElement(User::all()->all())->id : 1,
	];
} );
$factory->define ( Role::class, function (Faker\Generator $faker) {
	do
	{
		$array = [
			'name' => $faker->word,
			'active' => intval(random_int(0,10) !== 0),
			'created' => $faker->dateTime,
			'updated' => $faker->dateTime,
			'created_by' => User::all()->count() > 0 ? $faker->randomElement(User::all()->all())->id : 1,
			'updated_by' => User::all()->count() > 0 ? $faker->randomElement(User::all()->all())->id : 1,
		];
	} while(Role::where(['name' => $array['name']])->get()->count() > 0);
	return $array;
} );
$factory->define ( Group::class, function (Faker\Generator $faker) {
	do
	{
		$array = [
			'name' => $faker->word,
			'description' => $faker->sentences(random_int(1, 3), true),
			'active' => intval(random_int(0, 10) !== 0),
			'created' => $faker->dateTime,
			'updated' => $faker->dateTime,
			'created_by' => User::all()->count() > 0 ? $faker->randomElement(User::all()->all())->id : 1,
			'updated_by' => User::all()->count() > 0 ? $faker->randomElement(User::all()->all())->id : 1,
		];
	} while(Group::where(['name' => $array['name']])->get()->count() > 0);
	return $array;
} );
$factory->define ( Group_User::class, function (Faker\Generator $faker) {
	return [
		'user_id' => $faker->randomElement(User::all()->all())->id,
		'group_id' => $faker->randomElement(Group::all()->all())->id,
		'active' => intval(random_int(0,10) !== 0),
		'created' => $faker->dateTime,
		'updated' => $faker->dateTime,
		'created_by' => User::all()->count() > 0 ? $faker->randomElement(User::all()->all())->id : 1,
		'updated_by' => User::all()->count() > 0 ? $faker->randomElement(User::all()->all())->id : 1,
	];
} );
$factory->define ( App\Modules\MoneyPool\Models\MoneyPool::class, function (Faker\Generator $faker) {
	return [ 
			'active' => 1,
			'created' => $faker->dateTime,
			'updated' => $faker->dateTime,
			'entityName' => $faker->text(10),
			'entityId' => $faker->numberBetween(1, 50),
			'amount' => $faker->numberBetween(-50, 50),
	];
} );
$factory->define ( App\Modules\MoneyPool\Models\Transaction::class, function (Faker\Generator $faker) {
	return [ 
			'active' => 1,
			'created' => $faker->dateTime,
			'updated' => $faker->dateTime,
			'poolId' => $faker->numberBetween(1, 50),
			'comments' => $faker->text(255),
			'transGroupId' => $faker->md5,
			'amount' => $faker->numberBetween(-50, 50),
	];
} );
