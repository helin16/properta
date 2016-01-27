<?php

require_once __DIR__ . '/BasicTableSeederAbstract.php';
class MoneyPoolTableSeeder extends BasicTableSeederAbstract {
	protected $_entityName = App\Modules\MoneyPool\Models\MoneyPool::class;
}
