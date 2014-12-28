<?php
/**
 * This is the ContactUs page
 * 
 * @package    Web
 * @subpackage Controller
 * @author     lhe<helin16@gmail.com>
 */
class Controller extends FrontEndPageAbstract
{
    /**
     * (non-PHPdoc)
     * @see FrontEndPageAbstract::_getEndJs()
     */
    protected function _getEndJs()
    {
        $js = parent::_getEndJs();
        $js .="pageJs.setCallbackId('contactus', '" . $this->contactUsBtn->getUniqueId() . "')";
        $js .=".init('#main-form');";
        return $js; 
    }
	public function contactUs($sender, $param)
	{
		$results = $errors = array();
		try
		{
			$data = json_decode(json_encode($param->CallbackParameter), true);
			var_dump($data);
			$from = Core::getUser()->getPerson();
			$to = $param->CallbackParameter->to;
			$subject = $param->CallbackParameter->subject;
			$body = $param->CallbackParameter->comments;
			Message::create($from, $to, $subject, $body, Message::TYPE_EMAIL);
		}
		catch(Exception $ex)
		{
			$errors[] = $ex->getMessage();
		}
		$param->ResponseData = StringUtilsAbstract::getJson($results, $errors);
		return $this;
	}
}