<?php
class LoginController extends FrontEndPageAbstract
{
    protected function _getEndJs()
    {
        $js = parent::_getEndJs();
        $js .= 'pageJs.setCallbackId("login", "' . $this->loginBtn->getUniqueID() . '");';
        return $js;
    }
    
    public function login($sender, $params)
    {
        $errors = $results = array();
        try 
        {
            if(!isset($params->CallbackParameter->email) || ($email = trim($params->CallbackParameter->email)) === '')
                throw new Exception('email not provided!');
            if(!isset($params->CallbackParameter->password) || ($password = trim($params->CallbackParameter->password)) === '')
                throw new Exception('password not provided!');
            
            $authManager=$this->getApplication()->getModule('auth');
            if(!$authManager->login($email, $password))
            	throw new Exception('No user found!');
            $results['url'] = '/backend.html';
        }
        catch(Exception $ex)
        {
        	$errors[] = $ex->getMessage();
        }
        $params->ResponseData = StringUtilsAbstract::getJson($results, $errors);
    }
}