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
use App\Modules\Rental\Models\PropertyLog;
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

        $this->seed('UsersSeeder');
        $this->seed('AddressesSeeder');
//         $this->seed('BrandsSeeder');
        $this->command->info('Start seeding media, this may take a while');
        $this->seed('MediaSeeder');
//         $this->seed('ActionSeeder');
//         $this->seed('PermissionSeeder');
        $this->seed('PropertySeeder');
//         $this->seed('AdminAccessSeeder');
        $this->seed('RentalSeeder');
        $this->seed('RentalUserSeeder');
        $this->seed('IssueSeeder');
        $this->seed('MessagesSeeder');

        Model::reguard();
    }
    private function seed($className)
    {
        if(class_exists($className))
            $this->call($className);
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
        // roles
        $role_agency_admin = factory(Role::class)->create(['name' => 'agency admin', 'description' => '']);
        $role_agent = factory(Role::class)->create(['name' => 'agent', 'description' => '']);
        $role_tenant = factory(Role::class)->create(['name' => 'tenant', 'description' => '']);
        $role_landlord = factory(Role::class)->create(['name' => 'landlord', 'description' => '']);

        $usersInfo = [
          ['email' => 'agency_admin@test.com', 'role_id' => $role_agency_admin->id],
          ['email' => 'agent@test.com', 'role_id' => $role_agent->id],
          ['email' => 'tenant@test.com', 'role_id' => $role_tenant->id],
          ['email' => 'landlord@test.com', 'role_id' => $role_landlord->id],
        ];
        foreach($usersInfo as $userInfo) {
            $user = factory(User::class)->create($userInfo);
            $password = factory(Password::class)->create([
                'user_id' => $user->id,
                'password' => Hash::make(123456)
            ]);
            $userDetails = factory(UserDetail::class)->create([
                'user_id' => $user->id
            ]);
        }
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
        factory(Address::class)->create([
            'street' => '21 Hibiscus Dr',
            'suburb' => 'Wheelers Hill',
            'state' => 'VIC',
            'country' => 'Australia',
            'postcode' => '3150',
        ]);
        factory(Address::class)->create([
            'street' => '3/2 McKelvie Ct',
            'suburb' => 'Glen Waverley',
            'state' => 'VIC',
            'country' => 'Australia',
            'postcode' => '3150',
        ]);
        factory(Address::class)->create([
            'street' => '72/108 Greville St',
            'suburb' => 'Prahran',
            'state' => 'VIC',
            'country' => 'Australia',
            'postcode' => '3181',
        ]);
        factory(Address::class)->create([
            'street' => '77/75-77 Irving Rd',
            'suburb' => 'Toorak',
            'state' => 'VIC',
            'country' => 'Australia',
            'postcode' => '3142',
        ]);
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
        foreach(Address::all() as $address) {
            $property = factory(Property::class)->create([
                'address_id' => $address->id,
            ]);
            $property_detail = factory(PropertyDetail::class)->create([
                'property_id' => $property->id
            ]);
            $property_log = factory(PropertyLog::class)->create([
                'property_id' => $property->id
            ]);
        }
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
        foreach(RentalUser::all() as $rental_user) {
            for($i=0; $i<random_int(0,5); $i++) {
                $issue = factory(Issue::class)->create([
                    'requester_user_id' => $rental_user->user_id,
                    'rental_id' => $rental_user->rental_id,
                    'status' => random_int(0, 1),
                ]);
                $issue_detail = factory(IssueDetail::class)->create([
                    'issue_id' => $issue->id,
                ]);
                $issue_progress = factory(IssueProgress::class)->create([
                    'issue_id' => $issue->id,
                ]);
            }
        }
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
        foreach(Property::all() as $property)
            factory(Rental::class)->create([
                'property_id' => $property->id,
            ]);
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