<?php
/**
 * The BackEnd Page Abstract
 * 
 * @package    Web
 * @subpackage Class
 * @author     lhe<helin16@gmail.com>
 */
abstract class BackEndPageAbstract extends FrontEndPageAbstract 
{
	/**
	 * constructor
	 */
	public function __construct()
	{
	    parent::__construct();
	    self::checkUser();
	}
	/**
	 * checking the current user
	 */
	public static function checkUser()
	{
		if(!Core::getUser() instanceof UserAccount || (Core::getUser()->getId() === UserAccount::ID_GUEST_ACCOUNT))
			die(FrontEndPageAbstract::show404Page('Page Not Found', 'Oops, the page you are looking for is not there'));
		return true;
	}
	/**
	 * Getting The end javascript
	 *
	 * @return string
	 */
	protected function _getEndJs()
	{
		$js = 'if(typeof(PageJs) !== "undefined"){var pageJs = new PageJs(); }';
		return $js;
	}
	/**
	 * loading the page js class files
	 */
	protected function _loadPageJsClass()
	{
		parent::_loadPageJsClass();
		$cScripts = self::getLastestJS(__CLASS__);
		if (isset($cScripts['js']) && ($lastestJs = trim($cScripts['js'])) !== '')
			$this->getPage()->getClientScript()->registerScriptFile('BackEndPageJs', Prado::getApplication()->getAssetManager()->publishFilePath(dirname(__FILE__) . '/'  . $lastestJs, true));
		return $this;
	}
}
?>