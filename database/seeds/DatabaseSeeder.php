<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Modules\User\Models\user;

const SEED_LIMIT = 10;

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
//         $this->seed('UsersSeeder');
//         $this->seed('MessagesSeeder');

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
        user::where('email', '=', 'test@test.com')->delete();
        $user = factory(user::class)->create([
           'email' =>  'test@test.com'
        ]);

//         App\password::where('user_id', '=', $user->id)->delete();
//         $password = factory(App\password::class)->create([
//             'user_id' => $user->id,
//             'password' => Hash::make(str_random(15))
//         ]);
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
        factory(App\user::class, SEED_LIMIT)->create()->each(function($user){
            // password
            $password = factory(App\password::class)->create([
                'user_id' => $user->id,
                'password' => Hash::make(str_random(15))
            ]);
            echoDebug($user, $password);
            // user details
            $userDetails = factory(App\userDetails::class)->create([
                'user_id' => $user->id
            ]);
            echoDebug($user, $userDetails);
            // user relationship
            if(random_int(0,1) === 0)
            {
                $userRelationship = factory(App\userRelationships::class)->create([
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
        factory(App\messages::class, SEED_LIMIT)->create();
    }
}
function echoDebug($entity, $info)
{
    echo ( get_class($info) . ($info->id ? ('[' . $info->id . ']') : '') . ' created for ' . get_class($entity) . '[' . $entity->id . ']' . PHP_EOL );
}