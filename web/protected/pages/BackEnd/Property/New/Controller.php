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
		$js .= ".setCallbackId('checkAddr', '" . $this->checkAddrBtn->getUniqueID() . "')";
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
					$results['properties'][] = $property->getJson();
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