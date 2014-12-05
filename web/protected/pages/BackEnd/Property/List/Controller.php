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
		$js = parent::_getEndJs();
		$js .= "pageJs.setHTMLIDs(" . json_encode(array('resultDivId' => 'result-div', 'totalNoOfItemsId' => 'totalNoOfItemsId')) . ")";
		$js .= ".setCallbackId('getItems', '" . $this->getItemsBtn->getUniqueID() . "')";
		$js .= ".setPropRelTypes(" . Role::ID_TENANT . ", " . Role::ID_AGENT .", " . Role::ID_OWNER . ")";
		$js .= ".getResults(true, 10);";
		return $js;
	}
	/**
	 * Getting the items list
	 * 
	 * @param TCallback          $sender
	 * @param TCallbackParameter $param
	 * 
	 * @return Controller
	 */
	public function getItems($sender, $param)
	{
		$results = $errors = array();
		try 
		{
			$pageNo = 1;
			$pageSize = DaoQuery::DEFAUTL_PAGE_SIZE;
			
			if(isset($param->CallbackParameter->pagination))
			{
				$pageNo = $param->CallbackParameter->pagination->pageNo;
				$pageSize = $param->CallbackParameter->pagination->pageSize;
			}
			$serachCriteria = isset($param->CallbackParameter->searchCriteria) ? json_decode(json_encode($param->CallbackParameter->searchCriteria), true) : array();
			$where = array(1);
			$params = array();
			$stats = array();
			Property::getQuery()->eagerLoad('Property.rels', 'inner join', 'pro_rels', 'pro_rels.propertyId = pro.id AND pro_rels.personId = ' . Core::getUser()->getPerson()->getId());
			$objects = Property::getAllByCriteria(implode(' AND ', $where), $params, false, $pageNo, $pageSize, array(), $stats);
			
			$results['pageStats'] = $stats;
			$results['items'] = array();
			foreach($objects as $obj)
			{
				$array = $obj->getJson();
				$array['curRoleIds'] = array_map(create_function('$a', 'return intval($a->getId());'), Role::getPropertyRoles($obj, Core::getUser()->getPerson()));
				$results['items'][] = $array;
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