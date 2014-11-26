<?php
/**
 * This is the property list for the backend
 * 
 * @package    Web
 * @subpackage Controller
 * @author     lhe<helin16@gmail.com>
 */
class Controller extends BackEndPageAbstract
{
	/**
	 * (non-PHPdoc)
	 * @see CRUDPageAbstract::_getEndJs()
	 */
	protected function _getEndJs()
	{
		if (!($property = Property::getPropertyByKey(trim($this->Request['id']))) instanceof Property)
			throw new Exception('No requested property found');
		$curRoleIds = $this->_getCurrentRoleIds($property);
		if(count($curRoleIds) === 0)
			throw new Exception('Access Denied: requested property is NOT related to you');
		
		$array = array('item' => $property->getJson(), 
				'roles' => $this->_getRoles(),
				'curRoleIds' => $curRoleIds,
				'counts' => array(
						'people' => PropertyRel::countByCriteria('userAccountId = ? and propertyId = ?', array(Core::getUser()->getId(), $property->getId())), 
						'files' => 0,
						'leases' => 0
				)
		);
		$js = parent::_getEndJs();
		$js .= "pageJs.setHTMLIDs(" . json_encode(array('itemDivId' => 'item-details-div')) . ")";
		$js .= ".setCallbackId('getHistory', '" . $this->getHistoryBtn->getUniqueID() . "')";
		$js .= ".setCallbackId('getPeople', '" . $this->getPeopleBtn->getUniqueID() . "')";
		$js .= ".setCallbackId('updateDetails', '" . $this->updateDetailsBtn->getUniqueID() . "')";
		$js .= ".load(" . json_encode($array) . ");";
		return $js;
	}
	/**
	 * getting the role ids that the current user is related to this property
	 * 
	 * @return array
	 */
	private function _getCurrentRoleIds(Property $property)
	{
		$rels = PropertyRel::getAllByCriteria('propertyId = ? and userAccountId = ?', array($property->getId(), Core::getUser()->getId()));
		return array_map(create_function('$a', 'return $a->getRole()->getId();'), $rels);
	}
	/**
	 * Getting the array of roles
	 * 
	 * @return multitype:multitype:NULL
	 */
	private function _getRoles()
	{
		$roles = array();
		foreach(Role::getAll() as $role)
			$roles[] = array ( 'name' => $role->getName(), 'id' => $role->getId(), 'changeDetails' => in_array($role->getId(), array(Role::ID_AGENT, Role::ID_OWNER)));
		return $roles;
	}
	/**
	 * get history
	 *
	 * @param TCallback          $sender
	 * @param TCallbackParameter $param
	 *
	 * @return Controller
	 */
	public function getHistory($sender, $param)
	{
		$results = $errors = array();
		try
		{
			if(!isset($param->CallbackParameter->propertyId) || !($property = Property::getPropertyByKey(trim($param->CallbackParameter->propertyId))) instanceof Property)
				throw new Exception('Invalid Property.');
			$pageNo = isset($param->CallbackParameter->pageNo) ? trim($param->CallbackParameter->pageNo) : 1;
			$pageSize = isset($param->CallbackParameter->pageSize) ? trim($param->CallbackParameter->pageSize) : DaoQuery::DEFAUTL_PAGE_SIZE;
			
			$stats = $items = array();
			foreach($property->getLogs(null, true, $pageNo, $pageSize, array(), $stats) as $log)
			{
				$fullName = $log->getCreatedBy() instanceof UserAccount ? ($log->getCreatedBy()->getFirstName() . ' ' . $log->getCreatedBy()->getLastName()) : '';
				$array = array('comments' => $log->getComments(), 
						'by' => trim($fullName) === '' ? '' : (trim($log->getCreatedBy()->getId()) === trim(Core::getUser()->getId()) ? $fullName : StringUtilsAbstract::encriptedName($fullName)),
						'whenUTC' => trim($log->getCreated())
				);
				$items[] = $array;
			}
			$results['items'] = $items;
			$results['pagination'] = $stats;
		}
		catch(Exception $ex)
		{
			$errors[] = $ex->getMessage();
		}
		$param->ResponseData = StringUtilsAbstract::getJson($results, $errors);
		return $this;
	}
	/**
	 * get people
	 *
	 * @param TCallback          $sender
	 * @param TCallbackParameter $param
	 *
	 * @return Controller
	 */
	public function getPeople($sender, $param)
	{
		$results = $errors = array();
		try
		{
			if(!isset($param->CallbackParameter->propertyId) || !($property = Property::getPropertyByKey(trim($param->CallbackParameter->propertyId))) instanceof Property)
				throw new Exception('Invalid Property.');
			
			$stats = $items = array();
			foreach(PropertyRel::getAllByCriteria('userAccountId = ? and propertyId = ?', array(Core::getUser()->getId(), $property->getId())) as $ref)
			{
				$fullName = $ref->getUserAccount() instanceof UserAccount ? ($ref->getUserAccount()->getFirstName() . ' ' . $ref->getUserAccount()->getLastName()) : '';
				$userId = $ref->getUserAccount() instanceof UserAccount ? $ref->getUserAccount()->getId() : '';
				if(!isset($items[$userId]))
				{
					$items[$userId] = array(
						'id' => $userId,
						'name' => trim($fullName) === '' ? '' : (trim($ref->getUserAccount()->getId()) === trim(Core::getUser()->getId()) ? $fullName : StringUtilsAbstract::encriptedName($fullName)),
						'roleIds' => array()
					);
				}
				$items[$userId]['roleIds'][] = $ref->getRole()->getId();
			}
			$results['items'] = $items;
		}
		catch(Exception $ex)
		{
			$errors[] = $ex->getMessage();
		}
		$param->ResponseData = StringUtilsAbstract::getJson($results, $errors);
		return $this;
	}
	/**
	 * update details of the property
	 *
	 * @param TCallback          $sender
	 * @param TCallbackParameter $param
	 *
	 * @return Controller
	 */
	public function updateDetails($sender, $param)
	{
		$results = $errors = array();
		try
		{
			if(!isset($param->CallbackParameter->propertyId) || !($property = Property::getPropertyByKey(trim($param->CallbackParameter->propertyId))) instanceof Property)
				throw new Exception('Invalid Property.');
			$curRoleIds = $this->_getCurrentRoleIds($property);
			$canEdit = false;
			foreach($this->_getRoles() as $role)
			{
				if($role['changeDetails'] === true && in_array($role['id'], $curRoleIds))
				{
					$canEdit = true;
					break;
				}
			}
			if($canEdit === false)
				throw new Exception('Access denied.');
			if(!isset($param->CallbackParameter->field) || ($field = trim($param->CallbackParameter->field)) === '' || !method_exists($property, ($setter = 'set' . strtoupper(substr($field, 0, 1)) . substr($field, 1))) )
				throw new Exception('Invalid Field.');
			$data = (!isset($param->CallbackParameter->data) ? '' : trim($param->CallbackParameter->data));
			$results['item'] = $property->$setter($data)
				->save()
				->addLog(Log::TYPE_SYS, 'Changed "' . $field . '" to <span class="text-success">' . $data . "</span>", __CLASS__ . '::' . __FUNCTION__)
				->getJson();
		}
		catch(Exception $ex)
		{
			$errors[] = $ex->getMessage();
		}
		$param->ResponseData = StringUtilsAbstract::getJson($results, $errors);
		return $this;
	}
}
?>