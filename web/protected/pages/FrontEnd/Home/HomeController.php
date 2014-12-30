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
		$js .="pageJs.setCallbackId('contactus', '" . $this->contactUsBtn->getUniqueId() . "')";
		$js .=".init('#" . $this->getPage()->getForm()->getClientId() . "')";
		$js .=".load();";
		return $js;
	}
	public function getCaptchaKey()
	{
		$googleRecap = Config::get('google', 'reCaptcha');
		return $googleRecap['public-key'] ;
	}
	/**
	 * submit the contact us form
	 *
	 * @param TCallback          $sender
	 * @param TCallbackParameter $param
	 *
	 * @return Controller
	 */
	public function contactUs($sender, $param)
	{
		$results = $errors = array();
		try
		{
			$data = json_decode(json_encode($param->CallbackParameter), true);
			$conf = Config::get('google', 'reCaptcha');
			$resp = ReCaptcha::verifyResponse($conf['verify-url'], $_SERVER['REMOTE_ADDR'], $data['g-captcha'], $conf['secret-key']);
			if ($resp === null || !$resp->success)
				throw new Exception('Invalid Captcha Provided!');
			EmailSenderAbstract::sendEmail(Config::get('contact-us', 'tos'), $this->getAppName() . ' Contact Us: ' . $data['subject'], $data['comments'], $data['comments'], $data['email'], $data['name']);
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