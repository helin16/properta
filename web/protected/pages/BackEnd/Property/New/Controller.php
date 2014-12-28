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
		$property = new Property();
		$js = parent::_getEndJs();
		$js .= "pageJs.setHTMLIDs(" . json_encode(array('itemDivId' => 'item-details-div')) . ")";
		$js .= ".setPropRelTypes(" . Role::ID_TENANT . ", " . Role::ID_AGENT .", " . Role::ID_OWNER . ")";
		$js .= ".setCallbackId('checkAddr', '" . $this->checkAddrBtn->getUniqueID() . "')";
		$js .= ".setCallbackId('saveProperty', '" . $this->savePropertyBtn->getUniqueID() . "')";
		$js .= ".load(" . json_encode($property->getJson()) . ");";
		return $js;
	}
	/**
	 * checking the address
	 *
	 * @param TCallback          $sender
	 * @param TCallbackParameter $param
	 *
	 * @return Controller
	 */
	public function checkAddr($sender, $param)
	{
		$results = $errors = array();
		try
		{
			$addressObj = isset($param->CallbackParameter->checkAddr) ? json_decode(json_encode($param->CallbackParameter->checkAddr), true) : array();
			if(!is_array($addressObj) || count($addressObj) === 0)
				throw new Exception('System Error: can NOT check on provided address, insuffient data provided.');
			$address = Address::getByKey(Address::genKey($addressObj['street'], $addressObj['city'], $addressObj['region'], $addressObj['country'], $addressObj['postCode']));
			$results['address'] = array();
			$results['properties'] = array();
			if($address instanceof Address)
			{
				$results['address'] = $address->getJson();
				foreach(Property::getAllByCriteria('addressId = ?', array($address->getId())) as $property)
				{
					$propArray = $property->getJson();
					$propArray['curRoleIds'] = array_map(create_function('$a', 'return intval($a->getId());'), Role::getPropertyRoles($property, Core::getUser()->getPerson()));
					$results['properties'][] = $propArray;
				}
			}
		}
		catch(Exception $ex)
		{
			$errors[] = $ex->getMessage();
		}
		$param->ResponseData = StringUtilsAbstract::getJson($results, $errors);
		return $this;
	}
	/**
	 * creating the property
	 *
	 * @param TCallback          $sender
	 * @param TCallbackParameter $param
	 *
	 * @return Controller
	 */
	public function saveProperty($sender, $param)
	{
		$results = $errors = array();
		try
		{
			Dao::beginTransaction();
			if(!isset($param->CallbackParameter->relTypeId) || !($role = Role::get($param->CallbackParameter->relTypeId)) instanceof Role)
				throw new Exception('System Error: Invalid rel type provided.');
			
			$propertyObj = isset($param->CallbackParameter->newProperty) ? json_decode(json_encode($param->CallbackParameter->newProperty), true) : array();
			if(!is_array($propertyObj) || count($propertyObj) === 0)
				throw new Exception('System Error: can access provided information, insuffient data provided.');
			
			if(!isset($propertyObj['sKey']) || !($property = Property::getPropertyByKey(trim($propertyObj['sKey']))) instanceof Property)
			{
				$addressObj = $propertyObj['address'];
				$addrKey = Address::genKey($addressObj['street'], $addressObj['city'], $addressObj['region'], $addressObj['country'], $addressObj['postCode']);
				if(!($address = Address::getByKey($addrKey)) instanceof Address)
					$address = Address::create($addressObj['street'], $addressObj['city'], $addressObj['region'], $addressObj['country'], $addressObj['postCode']);
				$property = Property::create($address, trim($propertyObj['noOfRooms']), trim($propertyObj['noOfBaths']), trim($propertyObj['noOfCars']), trim($propertyObj['description']));
			}
			$property->addPerson(Core::getUser()->getPerson(), $role);
			$results['url'] = '/backend/property/' . $property->getSKey() . '.html';
			
			Dao::commitTransaction();
		}
		catch(Exception $ex)
		{
			Dao::rollbackTransaction();
			$errors[] = '<pre>' . $ex->getMessage(). "\n" . $ex->getTraceAsString() . '</pre>';
		}
		$param->ResponseData = StringUtilsAbstract::getJson($results, $errors);
		return $this;
	}
}
?>