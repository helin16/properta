<?php
use App\User;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Password;

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
        DB::table('password')->delete();
        $password = new Password();
        $password->password = Hash::make('test');
        $password->save();

        DB::table('user')->delete();
        $user = new User();
        $user->email = 'test@test.com';
        $user->password_id = $password->id;
        $user->save();
    }
}