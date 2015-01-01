<?php
/**
 * This is the property list for the backend
 * 
 * @package    Web
 * @subpackage Controller
 * @author     lhe<helin16@gmail.com>
 */
class Controller extends BackEndPageAbstract
{
	/**
	 * (non-PHPdoc)
	 * @see CRUDPageAbstract::_getEndJs()
	 */
	protected function _getEndJs()
	{
		$js = parent::_getEndJs();
		$js .= "pageJs.setHTMLIDs(" . json_encode(array('resultDivId' => 'result-div', 'totalNoOfItemsId' => 'totalNoOfItemsId', 'unreadMessageContentBodyId'=>'unread-message-content-body', 'messageContentBody'=> 'message-content-body')) . ")";
		$js .= ".setCallbackId('getItems', '" . $this->getItemsBtn->getUniqueID() . "')";
		$js .= ".setCallbackId('updateMessage', '" . $this->updateMessageBtn->getUniqueID() . "')";
		$js .= ".setPropRelTypes(" . Role::ID_TENANT . ", " . Role::ID_AGENT .", " . Role::ID_OWNER . ")";
		$js .= ".getResults(true, 10);";
		return $js;
	}
	/**
	 * Getting the items list
	 * 
	 * @param TCallback          $sender
	 * @param TCallbackParameter $param
	 * 
	 * @return Controller
	 */
	public function getItems($sender, $param)
	{
		$results = $errors = array();
		try 
		{
			$pageNo = 1;
			$pageSize = DaoQuery::DEFAUTL_PAGE_SIZE;
			
			if(isset($param->CallbackParameter->pagination))
			{
				$pageNo = $param->CallbackParameter->pagination->pageNo;
				$pageSize = $param->CallbackParameter->pagination->pageSize;
			}
			$serachCriteria = isset($param->CallbackParameter->searchCriteria) ? json_decode(json_encode($param->CallbackParameter->searchCriteria), true) : array();
			$where = array(1);
			$params = array();
			$stats = array();
			
			$objects = Message::getAllByCriteria('msg.fromId = :personId or msg.toId = :personId', array('personId'=>  Core::getUser()->getPerson()->getId()), true, $pageNo, $pageSize, array(), $stats);
			
			$results['pageStats'] = $stats;
			$results['items'] = array();
			foreach($objects as $obj)
			{
				$array = $obj->getJson();
				$results['items'][] = $array;
			}
		}
		catch(Exception $ex)
		{
			$errors[] = $ex->getMessage();
		}
		$param->ResponseData = StringUtilsAbstract::getJson($results, $errors);
		return $this;
	}
	public function updateMessage($sender, $param)
	{
		$results = $errors = array();
		try 
		{
			var_dump($param->CallbackParameter);
			
			$action = trim($param->CallbackParameter->action);
			if(!($message = Message::get(trim($param->CallbackParameter->message->id))) instanceof Message && $action !== 'NEW')
				throw new Exception('Invalid Message passed in!');
			
			if($action === 'MARKREAD')
			{
				$message->setIsRead(true)->save();
			} 
			else if($action === 'NEW')
			{
				$from = $param->CallbackParameter->message->from;
				$to = $param->CallbackParameter->message->to;
				$subject = $param->CallbackParameter->message->subject;
				$body = $param->CallbackParameter->message->body;
				$type = $param->CallbackParameter->message->type;
				$message = Message::create($from, $to, $subject, $body, $type);
			}
			
			
			$results['items'] = $message->getJson();
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