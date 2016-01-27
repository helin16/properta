<?php

use App\Modules\System\Models\Credential;
use App\Modules\System\Models\User;
require_once __DIR__ . '/BasicTableSeederAbstract.php';

class UserTableSeeder extends BasicTableSeederAbstract
{
	protected $_entityName = User::class;
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
        $system_user = factory ( $this->_entityName )->create([
            'firstname' => 'test',
            'lastname' => 'user',
            'email' => 'test@test.com',
            'active' => 1,
        ]);

        $system_user_credential = factory ( Credential::class )->create([
            'user_id' => $system_user->id,
            'username' => 'testuser',
            'password' => Hash::make('test'),
            'type' => Credential::TYPE_NORMAL,
            'active' => 1,
        ]);

        for($i = 0; $i < 50; $i++)
        {
            $user = factory($this->_entityName)->create();
            $credential = factory(Credential::class)->create([
                'user_id' => $user->id,
            ]);
        }
	}
}
