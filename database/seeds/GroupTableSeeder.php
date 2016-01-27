<?php
use App\Modules\MoneyPool\Models\Group;
use App\Modules\MoneyPool\Models\Group_User;
use App\Modules\System\Models\User;
require_once __DIR__ . '/BasicTableSeederAbstract.php';
class GroupTableSeeder extends BasicTableSeederAbstract {
	protected $_entityName = App\Modules\MoneyPool\Models\Group::class;
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		for($i = 0; $i < 10; $i++)
			factory ( Group::class )->create();
		foreach(User::all()->all() as $user)
		{
			factory ( Group_User::class )->create([
				'user_id' => $user->id,
			]);
		}
	}
}
