<?php namespace App\Modules\API\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\System\Models\User;

class TransactionController extends APIController {
	protected $_entityName = \App\Modules\MoneyPool\Models\Transaction::class;
	/**
	 * Getting all the transaction for a group
	 * @param unknown $groupId
	 */
	public function getTransPerGroup($groupId, $pageNo = null, $pageSize = self::DEFAULT_PAGE_SIZE) {
		$class = trim($this->_entityName);
		$query = $class::with(['pool' => function ($query) use ($groupId) {
			$query->where('active', 1)->where('entityName', Group::class)->where('entityId', $groupId);
		}])->distinct();
		if($pageNo !== null)
			$query->paginate ( $pageSize );
		$result = $query->get(['transGroupId']);
		$transGroupIds = [];
		foreach($result as $row)
			$transGroupIds[] = $row->transGroupId;
		$result = $class::where('transGroupId', $transGroupIds)->distinct()->get();
		return $result->toJson();
	}
}