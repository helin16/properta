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
						'people' => count(UserAccount::getUsersForProperty($property)), 
						'files' => 0,
						'leases' => 0
				)
		);
		$js = parent::_getEndJs();
		$js .= "pageJs.setHTMLIDs(" . json_encode(array('itemDivId' => 'item-details-div')) . ")";
		$js .= ".setCallbackId('getHistory', '" . $this->getHistoryBtn->getUniqueID() . "')";
		$js .= ".setCallbackId('getPeople', '" . $this->getPeopleBtn->getUniqueID() . "')";
		$js .= ".setCallbackId('updateDetails', '" . $this->updateDetailsBtn->getUniqueID() . "')";
		$js .= ".setCallbackId('saveRel', '" . $this->saveRelBtn->getUniqueID() . "')";
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
				$fullName = $log->getCreatedBy() instanceof UserAccount ? ($log->getCreatedBy()->getFullName()) : '';
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
				$fullName = $ref->getUserAccount() instanceof UserAccount ? ($ref->getUserAccount()->getFullName()) : '';
				$userId = $ref->getUserAccount() instanceof UserAccount ? $ref->getUserAccount()->getId() : '';
				if(!isset($items[$userId]))
				{
					$items[$userId] = array(
						'id' => $userId,
						'name' => trim($fullName) === '' ? '' : (trim($userId) === trim(Core::getUser()->getId()) ? $fullName : StringUtilsAbstract::encriptedName($fullName)),
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
			Dao::beginTransaction();
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
			Dao::commitTransaction();
		}
		catch(Exception $ex)
		{
			Dao::rollbackTransaction();
			$errors[] = $ex->getMessage();
		}
		$param->ResponseData = StringUtilsAbstract::getJson($results, $errors);
		return $this;
	}
	/**
	 * saving the property relactionship details
	 *
	 * @param TCallback          $sender
	 * @param TCallbackParameter $param
	 *
	 * @return Controller
	 */
	public function saveRel($sender, $param)
	{
		$results = $errors = array();
		try
		{
			Dao::beginTransaction();
			if(!isset($param->CallbackParameter->propertyId) || !($property = Property::getPropertyByKey(trim($param->CallbackParameter->propertyId))) instanceof Property)
				throw new Exception('Invalid Property.');
			if(!isset($param->CallbackParameter->userId) || !($user = UserAccount::get($param->CallbackParameter->userId)) instanceof UserAccount)
				throw new Exception('Invalid user.');
			if(!isset($param->CallbackParameter->roleId) || !($role = Role::get($param->CallbackParameter->roleId)) instanceof Role)
				throw new Exception('Invalid role.');
			if(!isset($param->CallbackParameter->action) || !in_array(($action = trim($param->CallbackParameter->action)), array('create', 'update', 'delete')))
				throw new Exception('Invalid action.');
			$curRoleIds = $this->_getCurrentRoleIds($property);
			$canEdit = false;
			foreach($this->_getRoles() as $r)
			{
				if($r['changeDetails'] === true && in_array($r['id'], $curRoleIds))
				{
					$canEdit = true;
					break;
				}
			}
			if($canEdit === false)
				throw new Exception('Access denied.');
			
			$rels = PropertyRel::getRelationships($property, $user, $role);
			$item = null;
			$message = 'Dear {roleName} of property: ' . $property->getAddress() . ',<br /><br />The user list is now changed by' . Core::getUser()->getFullName() . ':<br/><br />';
			if($action === 'create' )
			{
				$item = (count($rels) > 0) ?  $rels[0] : PropertyRel::create($property, $user, $role);
				$message .= 'A new User (' . $user->getFullName() . ', ' . $user->getEmail() . ') is now a ' . $role->getName() . ' of this property';
			}
			else if($action === 'update' )
			{
				if(count($rels) === 0)
					throw new Exception('System error: there is no such Rel when you are trying to update.');
				$item = $rels[0]
					->setProperty($property)
					->setRole($role)
					->setUserAccount($user)
					->save()
					->addLog(Log::TYPE_SYS, 'property has changed to this(SKEY=' . $property->getSKey() . '), user changed to: ' . $user->getEmail() . ', role change to : ' . $role->getName(), __CLASS__ . '::' . __FUNCTION__);
				$property->addLog(Log::TYPE_SYS, 'User changed to: ' . $user->getEmail() . ', role change to : ' . $role->getName(), __CLASS__ . '::' . __FUNCTION__);
				$message .= 'The User (' . $user->getFullName() . ', ' . $user->getEmail() . ') is now a ' . $role->getName() . ' of this property';
			}
			else if($action === 'delete' )
			{
				if(count($rels) === 0)
					throw new Exception('System error: there is no such Rel when you are trying to update.');
				$item = $rels[0]->setActive(false)
					->save()
					->addLog(Log::TYPE_SYS, 'The property (SKEY=' . $property->getSKey() . ') is no longer linked user(' . $user->getEmail() . ') with role:' . $role->getName(), __CLASS__ . '::' . __FUNCTION__);
				$property->addLog(Log::TYPE_SYS, 'User(' . $user->getEmail() . ') is no longer a ' . $role->getName() . ' of this property.', __CLASS__ . '::' . __FUNCTION__);
				$message .= 'User(' . $user->getFullName() . ', ' . $user->getEmail() . ') is no longer a ' . $role->getName() . ' of this property.';
			}
			else
				throw new Exception('Invalid action.');
			if(!$item instanceof PropertyRel)
				throw new Exception('System Error: updating NOT success.');
			
			$results['item'] = array(
				'id' => $item->getUserAccount()->getId(),
				'name' => trim($item->getUserAccount()->getFullName()) === '' ? '' : (trim($item->getUserAccount()->getId()) === trim(Core::getUser()->getId()) ? $item->getUserAccount()->getFullName() : StringUtilsAbstract::encriptedName($item->getUserAccount()->getFullName())),
				'roleIds' => array_map(create_function('$a', 'return $a->getId();'), Role::getPropertyRoles($property, $user))
			);
			
			//inform all the owners
			$owners = UserAccount::getUsersForProperty($property, Role::get(Role::ID_OWNER));
			foreach($owners as $owner)
				Message::create(UserAccount::get(UserAccount::ID_SYSTEM_ACCOUNT), $owner, Message::TYPE_SYS, 'Users changed for Property: ' . $property->getAddress(), str_replace('{roleName}', 'Owner', $message));
			
			//inform all the agents
			$agents = UserAccount::getUsersForProperty($property, Role::get(Role::ID_AGENT));
			foreach($agents as $agent)
				Message::create(UserAccount::get(UserAccount::ID_SYSTEM_ACCOUNT), $agent, Message::TYPE_SYS, 'Users changed for Property: ' . $property->getAddress(), str_replace('{roleName}', 'Agent', $message));
			Dao::commitTransaction();
		}
		catch(Exception $ex)
		{
			Dao::rollbackTransaction();
			$errors[] = $ex->getMessage();
		}
		$param->ResponseData = StringUtilsAbstract::getJson($results, $errors);
		return $this;
	}
}
?>