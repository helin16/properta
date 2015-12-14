<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Modules\User\Models\User;
use App\Modules\Password\Models\Password;
use App\Modules\UserDetails\Models\UserDetails;
use App\Modules\UserRelationship\Models\UserRelationship;
use App\Modules\Message\Models\Message;

const SEED_LIMIT = 10;
const MESSAGE_SEED_MULTI = 10;

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
        $this->seed('MessagesSeeder');

        Model::reguard();
    }
    private function seed($className)
    {
        if(class_exists($className))
        {
            $this->call($className);
        }
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
            // user details
            $userDetails = factory(UserDetails::class)->create([
                'user_id' => $user->id
            ]);
            echoDebug($user, $userDetails);
            // user relationship
            if(random_int(0,1) === 0)
            {
                $userRelationship = factory(UserRelationship::class)->create([
                    'user_id' => $user->id
                ]);
                echoDebug($user, $userRelationship);
            }
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
function echoDebug($entity, $info)
{
    echo ( get_class($info) . ($info->id ? ('[' . $info->id . ']') : '') . ' created for ' . get_class($entity) . '[' . $entity->id . ']' . PHP_EOL );
}