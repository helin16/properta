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
		$js .= ".setCallbackId('checkAddr', '" . $this->checkAddrBtn->getUniqueID() . "')";
		$js .= ".getResults(true, 30);";
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
			$objects = Property::getAllByCriteria(implode(' AND ', $where), $params, false, $pageNo, $pageSize, array(), $stats);
			
			$results['pageStats'] = $stats;
			$results['items'] = array();
			foreach($objects as $obj)
				$results['items'][] = $obj->getJson();
		}
		catch(Exception $ex)
		{
			$errors[] = $ex->getMessage();
		}
		$param->ResponseData = StringUtilsAbstract::getJson($results, $errors);
		return $this;
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
			$objects = Property::getAllByCriteria(implode(' AND ', $where), $params, false, $pageNo, $pageSize, array(), $stats);
			
			$results['pageStats'] = $stats;
			$results['items'] = array();
			foreach($objects as $obj)
				$results['items'][] = $obj->getJson();
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