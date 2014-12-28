<?php
/**
 * This is the loginpage
 * 
 * @package    Web
 * @subpackage Controller
 * @author     lhe<helin16@gmail.com>
 */
class HomeController extends FrontEndPageAbstract
{
	/**
	 * (non-PHPdoc)
	 * @see FrontEndPageAbstract::_getEndJs()
	 */
	protected function _getEndJs()
	{
		$js = parent::_getEndJs();
		$js .="pageJs.init('#main-form')";
		$js .=".load();";
		return $js;
	}
	public function getCaptchaKey()
	{
		$googleRecap = Config::get('google', 'reCaptcha');
		return $googleRecap['public-key'] ;
	}
}
?>