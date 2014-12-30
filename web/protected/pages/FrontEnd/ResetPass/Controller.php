<?php
class Controller extends FrontEndPageAbstract
{
	/**
	 * (non-PHPdoc)
	 * @see FrontEndPageAbstract::_getEndJs()
	 */
    protected function _getEndJs()
    {
        $js = parent::_getEndJs();
        if(!$this->getPage()->IsPostBack || !$this->getPage()->IsCallback)
        {
        	if(!isset($this->Request['skey']) || !($confirmation = Confirmation::getBySkeyNotExpired(trim($this->Request['skey']))) instanceof Confirmation || !($userAccount = $confirmation->getEntity()) instanceof UserAccount) {
        		$this->resetForm->getControls()->add("<h3 class='text-center'><div class='label label-danger'>Invalid KEY</div></h3>");
        		return;
        	}
        	$resultPanelId = "reset-panel";
        	$this->resetForm->getControls()->add("<div id='" . $resultPanelId ."'></div>");
        	$js .= 'pageJs.setCallbackId("reset-pass", "' . $this->resetPassBtn->getUniqueID() . '")';
        	$js .= '.init("' . $resultPanelId .'", "#' . $this->getPage()->getForm()->getClientId() . '", "' . trim($this->Request['skey']) .'", "' . $userAccount->getUsername() . '");';
        }
        return $js;
    }
    /**
     * reset password
     *
     * @param TCallback          $sender
     * @param TCallbackParameter $param
     *
     * @return Controller
     */
    public function resetPass($sender, $param)
    {
    	$results = $errors = array();
    	try
    	{
    		Dao::beginTransaction();
    		$data = json_decode(json_encode($param->CallbackParameter), true);
    		if(!isset($data['new_pass']) || ($newPass = trim($data['new_pass'])) === '')
    			throw new Exception('No password passed in!');
    		if(!isset($data['skey']) || !($confirmation = Confirmation::getBySkeyNotExpired($data['skey'])) instanceof Confirmation)
    			throw new Exception('System Error: Invlaid confirm key!');
    		$entity = $confirmation->getEntity();
    		if(!$entity instanceof UserAccount)
    			throw new Exception('What are you trying to do!');
    		if(!Core::getUser() instanceof UserAccount)
    			Core::setUser(UserAccount::get(UserAccount::ID_GUEST_ACCOUNT));
    		$entity->confirm()
    			->setPassword($newPass, true)
    			->save();
    		$results['url'] = '/login.html';
    		Dao::commitTransaction();
    	}
    	catch(Exception $ex)
    	{
    		Dao::rollbackTransaction();
    		$errors[] = $ex->getMessage();
    	}
    	$param->ResponseData = StringUtilsAbstract::getJson($results, $errors);
    	return $this;
    }
}