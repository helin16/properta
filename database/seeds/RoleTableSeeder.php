<?php
require_once __DIR__ . '/BasicTableSeederAbstract.php';
use App\Modules\System\Models\User;
use App\Modules\System\Models\Role;
class RoleTableSeeder extends BasicTableSeederAbstract {
	protected $_entityName = App\Modules\System\Models\Role::class;
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		factory ( Role::class, 10 )->create();
	}
}
