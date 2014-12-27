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
						'people' => count(Person::getUsersForProperty($property)), 
						'files' => 0,
						'leases' => 0
				)
		);
		$js = parent::_getEndJs();
		$js .= "pageJs.setHTMLIDs(" . json_encode(array('itemDivId' => 'item-details-div')) . ")";
		$js .= ".setCallbackId('getHistory', '" . $this->getHistoryBtn->getUniqueID() . "')";
		$js .= ".setCallbackId('getPeople', '" . $this->getPeopleBtn->getUniqueID() . "')";
		$js .= ".setCallbackId('getNewPeople', '" . $this->getNewPeopleBtn->getUniqueID() . "')";
		$js .= ".setCallbackId('addPerson', '" . $this->addPersonBtn->getUniqueID() . "')";
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
		$rels = PropertyRel::getAllByCriteria('propertyId = ? and personId = ?', array($property->getId(), Core::getUser()->getPerson()->getId()));
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
	public function getNewPeople($sender, $param) 
	{
		$results = $errors = array();
		try
		{
			$stats = $items = array();
			$people = Person::getAllByCriteria('email like :searchTxt or firstName like :searchTxt or lastName like :searchTxt', array('searchTxt' => '%' . trim($param->CallbackParameter->searchText) . '%' ));
			foreach($people as $person )
			{
				$items[] = $person->getJson();
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
	public function addPerson($sender, $param) 
	{
		$results = $errors = array();
		try
		{
			$stats = $items = array();
// 			var_dump($param->CallbackParameter);
			
			$person = Person::get(trim($param->CallbackParameter->person->id));
			if(!$person instanceof Person)
				throw new Exception('Invalid Person passed in!');
			$propterty = Property::get(trim($param->CallbackParameter->property->id));
			if(!$propterty instanceof Property)
				throw new Exception('Invalid Property passed in!');
			PropertyRel::create($propterty, $person, $role);
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
			foreach(PropertyRel::getAllByCriteria('personId = ? or propertyId = ?', array(Core::getUser()->getPerson()->getId(), $property->getId())) as $ref)
			{
				$fullName = $ref->getPerson() instanceof Person ? ($ref->getPerson()->getFullName()) : '';
				$personId = $ref->getPerson() instanceof Person ? $ref->getPerson()->getId() : '';
				if(!isset($items[$personId]))
				{
					$items[$personId] = array(
						'id' => $personId,
						'name' => trim($fullName) === '' ? '' : $fullName,
						'roleIds' => array()
					);
				}
				$items[$personId]['roleIds'][] = $ref->getRole()->getId();
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
			var_dump($param->CallbackParameter);
			Dao::beginTransaction();
			if(!isset($param->CallbackParameter->propertyId) || !($property = Property::getPropertyByKey(trim($param->CallbackParameter->propertyId))) instanceof Property)
				throw new Exception('Invalid Property.');
			if(!isset($param->CallbackParameter->userId) || !($person = Person::get($param->CallbackParameter->userId)) instanceof Person)
				$person = Person::create($param->CallbackParameter->firstName, $param->CallbackParameter->lastName, $param->CallbackParameter->email);
			if(!isset($param->CallbackParameter->roleId) )
				throw new Exception('Invalid roles.');
			$roles = array();
			foreach ($param->CallbackParameter->roleId as $roleId)
			{
				if(!(($role= Role::get($roleId->id)) instanceof Role))
					throw new Exception('Invalid role.');
				$roles[]= $role;
			}
			if(!isset($param->CallbackParameter->action) || !in_array(($action = trim($param->CallbackParameter->action)), array('create', 'update', 'delete', 'addUser')))
				throw new Exception('Invalid action.');
			$curRoleIds = $this->_getCurrentRoleIds($property);
			$canEdit = trim($param->CallbackParameter->action) === 'addUser' ? true :false;
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
			
			foreach ($roles as $role)
			{
				var_dump($person);
				$rels = PropertyRel::getRelationships($property, $person, $role);
				$item = null;
				if($action === 'create' or $action === 'addUser')
				{
					$item = (count($rels) > 0) ?  $rels[0] : PropertyRel::create($property, $person, $role);
				}
				else if($action === 'delete' )
				{
					if(count($rels) === 0)
						throw new Exception('System error: there is no such Rel when you are trying to update.');
					$item = $rels[0]->setActive(false)
						->save()
						->addLog(Log::TYPE_SYS, 'The property (SKEY=' . $property->getSKey() . ') is no longer linked user(' . $person->getFullName() . ') with role:' . $role->getName(), __CLASS__ . '::' . __FUNCTION__);
					$property->addLog(Log::TYPE_SYS, 'User(' . $person->getFullName() . ') is no longer a ' . $role->getName() . ' of this property.', __CLASS__ . '::' . __FUNCTION__);
				}
				else
					throw new Exception('Invalid action.');
				
				
				
			}
			
			if(!$item instanceof PropertyRel)
				throw new Exception('System Error: updating NOT success.');
			
			$results['item'] = array(
				'id' => $item->getPerson()->getId(),
				'name' => trim($item->getPerson()->getFullName()) === '' ? '' : (trim($item->getPerson()->getId()) === trim(Core::getUser()->getId()) ? $item->getPerson()->getFullName() : StringUtilsAbstract::encriptedName($item->getPerson()->getFullName())),
				'roleIds' => array_map(create_function('$a', 'return $a->getId();'), Role::getPropertyRoles($property, $person))
			);
			
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