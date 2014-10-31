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
	    if(!Core::getUser() instanceof UserAccount || (Core::getUser()->getId() === UserAccount::ID_GUEST_ACCOUNT))
	    	die(FrontEndPageAbstract::show404Page('Page Not Found', 'Oops, the page you are looking for is not there'));
	}
}
?>