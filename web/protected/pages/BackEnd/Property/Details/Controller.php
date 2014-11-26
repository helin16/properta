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
		if(intval(PropertyRel::countByCriteria('propertyId = ? and userAccountId = ?', array($property->getId(), Core::getUser()->getId()))) === 0)
			throw new Exception('Access Denied: requested property is NOT related to you');
		
		$array = array('item' => $property->getJson(), 'counts' => array('people' => PropertyRel::countByCriteria('userAccountId = ? and propertyId = ?', array(Core::getUser()->getId(), $property->getId())), 'files' => 0));
		$js = parent::_getEndJs();
		$js .= "pageJs.setHTMLIDs(" . json_encode(array('itemDivId' => 'item-details-div')) . ")";
		$js .= ".setCallbackId('getHistory', '" . $this->getHistoryBtn->getUniqueID() . "')";
		$js .= ".setCallbackId('getPeople', '" . $this->getPeopleBtn->getUniqueID() . "')";
		$js .= ".load(" . json_encode($array) . ");";
		return $js;
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
			$results['roles'] = array();
			foreach(Role::getAll() as $role)
			{
				$results['roles'][] = array (
					'name' => $role->getName(),
					'id' => $role->getId()
				);
			}
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