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
}