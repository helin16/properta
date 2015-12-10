<?php
use App\User;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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

        $this->seed('UserTableSeeder');

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
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        User::create(['email' => 'test@test.com', 'password' => Hash::make('test')]);
    }
}