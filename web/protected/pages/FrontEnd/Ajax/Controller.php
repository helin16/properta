<?php
/**
 * This is the Ajax Service
 * 
 * @package    Web
 * @subpackage Controller
 * @author     lhe<helin16@gmail.com>
 *
 */
class Controller extends TService
{
    /**
     * (non-PHPdoc)
     * @see TService::run()
     */
    public function run()
    {
    	$results = $errors = array();
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
     * Internal function to get the entity
     * 
     * @param array $params
     * 
     * @throws Exception
     * @return BaseEntityAbstract
     */
    private function __getEntity($params)
    {
    	if(!isset($param['entityId']) || !isset($param['entityName']))
    		throw new Exception('EntityId and EntityName needed.');
    	try{
    		if(!class_exists($param['entityName']))
    			throw new Exception();
    	} catch(Exception $ex) {
    		throw new Exception('EntityName not exsits:' . $param['entityName']);
    	}
    	$className = trim($param['entityName']);
    	if(!($entity = $className::get(trim($param['entityId']))) instanceof $className)
    		throw new Exception('Nothing found for ' . $className . ' with id: ' . $param['entityId']);
    	return $entity;
    }
    /**
     * adding a entity tag to an entity
     * 
     * @param array $params
     * 
     * @throws Exception
     */
    private function _addEntityTag($params)
    {
    	if(!isset($param['tagName']) || !isset($param['type']))
    		throw new Exception('tagName and type needed.');
    	$entity = $this->__getEntity($params);
	    $entityTag = null;
	    $entity->addTag(trim($param['tagName']), trim($param['type']), $entityTag);
	    return $entityTag->getJson();
    }
    /**
     * remove entity tags from an entity
     * 
     * @param array $params
     * 
     * @throws Exception
     */
    private function _removeEntityTag($params)
    {
    	$entity = $this->__getEntity($params);
    	$tagName = isset($param['tagName']) ? trim($param['tagName']) : null;
    	$type = isset($param['type']) ? trim($param['type']) : null;
    	
	    $entity->removeTag($type, $tagName);
	    return $entity->getJson();
    }
}