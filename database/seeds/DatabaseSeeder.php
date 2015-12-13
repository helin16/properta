<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\password;
use App\user;

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

        Model::reguard();
    }
    private function seed($className)
    {
        if(class_exists($className))
        {
            $this->call($className);
            $this->command->info($className . ' table seeded!');
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
        DB::table('users')->delete();
        $user = new user();
        $user->email = 'test@test.com';
        $user->save();

        DB::table('passwords')->delete();
        $password = new password();
        $password->password = Hash::make('test');
        $password->user_id = $user->id;
        $password->save();

    }
}