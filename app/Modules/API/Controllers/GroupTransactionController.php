<?php namespace App\Modules\API\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\System\Models\User;
use App\Modules\MoneyPool\Models\MoneyPool;
use App\Modules\MoneyPool\Models\Group;

class GroupTransactionController extends APIController {
	protected $_entityName = \App\Modules\MoneyPool\Models\Transaction::class;
	/**
	 * {@inheritDoc}
	 * @see \App\Modules\API\Controllers\APIController::show()
	 */
	public function show($groupId, $someId = null)
	{
		$pageNo = \Request::query('pageNo');
		return \App::make(TransactionController::class)->getTransPerGroup($groupId, ($pageNo === false ? null : intval($pageNo)));
	}
}