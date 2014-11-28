<?php
/**
 * This is the Ajax Service
 * 
 * @package    Web
 * @subpackage Controller
 * @author     lhe<helin16@gmail.com>
 *
 */
class AjaxController extends TService
{
    /**
     * (non-PHPdoc)
     * @see TService::run()
     */
    public function run()
    {
        try 
        {
            $method = '_' . ((isset($this->Request['method']) && trim($this->Request['method']) !== '') ? trim($this->Request['method']) : '');
            if(!method_exists($this, $method))
                throw new Exception('No such a method: ' . $method . '!');
          	
            $results = $this->$method($_REQUEST);
        }
        catch (Exception $ex)
        {
        	$errors = $ex->getMessage();
        }
        return StringUtilsAbstract::getJson($results, $errors);
    }
    /**
     * Getting the id
     * 
     * @param array $params
     * 
     * @return mix
     */
    private function _getUsers($params)
    {
    	if(!isset($params['searchTxt']) || ($searchTxt = trim($params['searchTxt'])) === '')
    		throw new Exception('Nothing to get!');
    	$stats = array();
    	$pageNo = (!isset($params['pageNo']) || !is_numeric($params['pageNo'])) ? null : trim($params['pageNo']);
    	$pageSize = (!isset($params['pageSize']) || !is_numeric($params['pageSize'])) ? DaoQuery::DEFAUTL_PAGE_SIZE : trim($params['pageSize']);
    	$orderBy = (!isset($params['orderBy']) || !is_array($params['orderBy'])) ? array() : $params['orderBy'];
    	$activeOnly = (!isset($params['activeOnly']) || intval($params['activeOnly']) !== 0) ? true : false;
    	$array['items'] = UserAccount::getAllByCriteria('email like :searchTxt or firstName like :seachTxt or lastName like :searchTxt or concat(firstName, " ", lastName) like :searchTxt', arary('searchTxt' => '%' . $searchTxt . '%'), $activeOnly, $pageNo, $pageSize, $orderBy, $stats)
    	$array['pagination'] = $stats;
    	return $array;
    }
}