<?php
class LoginController extends FrontEndPageAbstract
{
    protected function _getEndJs()
    {
        $js = parent::_getEndJs();
        $js .= 'pageJs.setCallbackId("login", "' . $this->loginBtn->getUniqueID() . '")';
        $js .= '.setCallbackId("signUp", "' . $this->signUpBtn->getUniqueID() . '")';
        $js .= '.setCallbackId("retrieve-pass", "' . $this->retrievePassBtn->getUniqueID() . '")';
        $js .= ".init('#" .  $this->getPage()->getForm()->getClientId() . "')";
        $js .= '._ressultPanelId = "main-panel";';
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
    /**
     * signingup
     * 
     * @param unknown $sender
     * @param unknown $params
     * 
     * @throws Exception
     */
    public function signUp($sender, $params)
    {
        $errors = $results = array();
        try 
        {
        	Dao::beginTransaction();
            if(!isset($params->CallbackParameter->email) || ($email = trim($params->CallbackParameter->email)) === '')
                throw new Exception('email not provided!');
            if(UserAccount::countByCriteria('username = ?', array($email)) > 0)
                throw new Exception('Provided email exisits');
            $password = StringUtilsAbstract::getRandKey($email);
            Core::setUser(UserAccount::get(UserAccount::ID_GUEST_ACCOUNT));
            
            $newUser = UserAccount::create($email, $password, ($person = Person::create($email, 'User', $email)));
            $appInfo = Core::getAppMetaInfo();
            Message::create(Core::getUser()->getPerson(), $person, 
            	($subject = 'Welcome to ' . $appInfo['name'] . ', you are just one step away from it.') , 
            	'<h3>' . $subject . '</h3>'
            	.'<div>'
            		.'<div>here is your initial login details, please change it after you logged in</div>'
            		.'<div><b>Username: </b>' . $email . ' </div>'
            		.'<div><b>Initial Password: </b>' . $password . ' </div>'
            	.'</div>', 
            	Message::TYPE_EMAIL
            ); 
            $results['confirmEmail'] = $email;
        	Dao::commitTransaction();
        }
        catch(Exception $ex)
        {
        	Dao::rollbackTransaction();
        	$errors[] = $ex->getMessage();
        }
        $params->ResponseData = StringUtilsAbstract::getJson($results, $errors);
    }
    /**
     * retrieving a password
     * 
     * @param unknown $sender
     * @param unknown $params
     * 
     * @throws Exception
     */
    public function retrievePass($sender, $params)
    {
    	$errors = $results = array();
    	try
    	{
    		Dao::beginTransaction();
            if(!isset($params->CallbackParameter->email) || ($email = trim($params->CallbackParameter->email)) === '')
                throw new Exception('email not provided!');
            if(count($userAccounts =UserAccount::getAllByCriteria('username = ?', array($email), true, 1, 1)) === 0)
                throw new Exception('There is no such an email exisits');
            
            $password = StringUtilsAbstract::getRandKey($email);
            Core::setUser(UserAccount::get(UserAccount::ID_GUEST_ACCOUNT));
            
            $appInfo = Core::getAppMetaInfo();
            Message::create(Core::getUser()->getPerson(), $person, 
            	($subject = 'Resetting your ' . $appInfo['name'] . ' password.') , 
            		'<h3>' . $subject . '</h3>'
            		.'<div>'
            			.'<div>here is your initial login details, please change it after you logged in</div>'
            			.'<div><b>Username: </b>' . $email . ' </div>'
            			.'<div><b>Initial Password: </b>' . $password . ' </div>'
            		.'</div>',  Message::TYPE_EMAIL); 
            $results['confirmEmail'] = $email;
        	Dao::commitTransaction();
    	}
    	catch(Exception $ex)
    	{
        	Dao::rollbackTransaction();
    		$errors[] = $ex->getMessage();
    	}
    	$params->ResponseData = StringUtilsAbstract::getJson($results, $errors);
    }
}