<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Modules\User\Models\User;
use App\Modules\User\Models\Password;
use App\Modules\User\Models\UserDetail;
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

const SEED_LIMIT = 10;
const MESSAGE_SEED_MULTI = 10;
const ADDRESS_SEED_MULTI = 2;
const PROPERTY_LOG_SEED_MULTI = 3;
const RENTAL_SEED_MULTI  = 3;
const RENTAL_USER_SEED_MULTI = 3;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->seed('SystemUserSeeder');
        $this->seed('UsersSeeder');
//         $this->seed('MessagesSeeder');
        $this->seed('AddressesSeeder');
//         $this->seed('BrandsSeeder');
        $this->command->info('Start seeding media, this may take a while');
        $this->seed('MediaSeeder');
        $this->seed('RoleSeeder');
//         $this->seed('ActionSeeder');
//         $this->seed('PermissionSeeder');
        $this->seed('PropertySeeder');
//         $this->seed('PropertyDetailSeeder');
//         $this->seed('PropertyLogSeeder');
//         $this->seed('AdminAccessSeeder');
        $this->seed('RentalSeeder');
        $this->seed('RentalUserSeeder');
        $this->seed('IssueSeeder');
        $this->seed('IssueDetailSeeder');
        $this->seed('IssueProgressSeeder');

        Model::reguard();
    }
    private function seed($className)
    {
        if(class_exists($className))
            $this->call($className);
    }
}
class SystemUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::where('email', '=', 'test@test.com')->delete();
        $user = factory(User::class)->create([
           'email' =>  'test@test.com'
        ]);

        Password::where('user_id', '=', $user->id)->delete();
        $password = factory(Password::class)->create([
            'user_id' => $user->id,
            'password' => Hash::make(str_random(15))
        ]);
    }
}
class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, SEED_LIMIT)->create()->each(function($user){
            // password
            $password = factory(Password::class)->create([
                'user_id' => $user->id,
                'password' => Hash::make(str_random(15))
            ]);
            echoDebug($user, $password);
//             user details
             $userDetails = factory(UserDetail::class)->create([
                 'user_id' => $user->id
             ]);
             echoDebug($user, $userDetails);
            // user relationship
//             if(random_int(0,1) === 0)
//             {
//                 $userRelationship = factory(UserRelationship::class)->create([
//                     'user_id' => $user->id
//                 ]);
//                 echoDebug($user, $userRelationship);
//             }
        });
    }
}
class MessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Message::class, User::all()->count() * MESSAGE_SEED_MULTI)->create();
    }
}
class AddressesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Address::class, User::all()->count() * ADDRESS_SEED_MULTI)->create();
    }
}
class BrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Brand::class, SEED_LIMIT)->create();
    }
}
class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Media::class, SEED_LIMIT)->create();
    }
}
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Role::class, SEED_LIMIT)->create();
    }
}
class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Action::class, SEED_LIMIT)->create();
    }
}
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Permission::class, SEED_LIMIT)->create();
    }
}
class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Property::class, SEED_LIMIT)->create()->each(function($property){
            $property_detail = factory(PropertyDetail::class)->create([
                'property_id' => $property->id
            ]);
            echoDebug($property, $property_detail);
        });
    }
}
class PropertyDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(PropertyDetail::class, SEED_LIMIT)->create();
    }
}
class PropertyLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(PropertyLog::class, Property::all()->count() * PROPERTY_LOG_SEED_MULTI)->create();
    }
}
class AdminAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(AdminAccess::class, Property::all()->count())->create();
    }
}
class IssueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Issue::class, Property::all()->count())->create();
    }
}
class IssueDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(IssueDetail::class, Issue::all()->count())->create();
    }
}
class IssueProgressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(IssueProgress::class, Issue::all()->count())->create();
    }
}
class RentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Rental::class, Property::all()->count() * RENTAL_SEED_MULTI)->create();
    }
}
class RentalUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(RentalUser::class, Rental::all()->count() * RENTAL_USER_SEED_MULTI)->create();
    }
}
function echoDebug($entity, $info)
{
    echo ( get_class($info) . ($info->id ? ('[' . $info->id . ']') : '') . ' created for ' . get_class($entity) . '[' . $entity->id . ']' . PHP_EOL );
}