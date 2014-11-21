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
		if(trim($this->Request['id']) === 'new')
			$property = new Property();
		else 
		{
			if (!($property = Property::getPropertyByKey(trim($this->Request['id']))) instanceof Property)
				throw new Exception('No requested property found');
			if(intval(PropertyRel::countByCriteria('propertyId = ? and userAccountId = ?', array($property->getId(), Core::getUser()->getId()))) === 0)
				throw new Exception('Access Denied: requested property is NOT related to you');
		}
		
		$js = parent::_getEndJs();
		$js .= "pageJs.setHTMLIDs(" . json_encode(array('itemDivId' => 'item-details-div')) . ")";
		$js .= ".load(" . json_encode($property->getJson()) . ");";
		return $js;
	}
}
?>