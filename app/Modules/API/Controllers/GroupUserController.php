<?php namespace App\Modules\API\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\System\Models\User;

class GroupUserController extends APIController {
	protected $_entityName = \App\Modules\MoneyPool\Models\Group_User::class;
	/**
	 * {@inheritDoc}
	 * @see \App\Modules\API\Controllers\APIController::show()
	 */
	public function show($groupId, $someId = null)
	{
		$class = trim($this->_entityName);
		$result = $class::where('groupId', $groupId)->distinct()->get(['userId']);
		$userIds = [];
		foreach($result as $row)
			$userIds[] = $row->userId;
		$result = User::find($userIds);
		return $result->toJson();
	}
}