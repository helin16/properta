<?php
require_once dirname(__FILE__) . '/bootstrap.php';
/**
 * The message sender
 * 
 * @author lhe
 */
abstract class MessageSender
{
	/**
	 * The executer
	 */
	public static function run()
	{
		$messages = self::_getMessages();
		self::_log("Got " . count($messages) . ' messages to send:', __FUNCTION__);
		foreach($messages as $message) {
			try {
				Dao::beginTransaction();
				self::_log("Processing Message (ID= " . $message->getId() . '):', __FUNCTION__);
				$message = self::_sendMessage($message);
				self::_log("Message (ID= " . $message->getId() . ') is NOW sent!', __FUNCTION__);
				Dao::commitTransaction();
			} catch (Exception $e) {
				Dao::rollbackTransaction();
				self::_log('ERROR When sending Message (ID=' . $message->getId() . '), marked it back to NEW: ' .$e->getMessage() , __FUNCTION__);
				self::_log('\t::' . $e->getTraceAsString() , __FUNCTION__);
				$message->setSendType(Message::SENT_TYPE_NEW)
					->save();
			}
		}
	}
	/**
	 * Message sender
	 * 
	 * @param Message $message
	 * 
	 * @throws Exception
	 */
	private static function _sendMessage(Message $message)
	{
		EmailSenderAbstract::sendEmail(array($message->getTo()->getEmail()), $message->getSubject(), $message->getBody());
		$message->setSendType(Message::SENT_TYPE_SENT)
			->save();
		return $message;
	}
	/**
	 * Getting the next batch of message to send
	 * 
	 * @return Ambigous <Ambigous, multitype:, multitype:BaseEntityAbstract >
	 */
	private static function _getMessages()
	{
		Message::up
		$messages = Message::getAllByCriteria('sendType = ?', array(Message::SENT_TYPE_NEW));
		if(count($messages) > 0)
		{
			$ids = array_map(create_function('$a', 'return $a->getId();'), $messages);
			Message::updateByCriteria('sendType = ?', 'id in (' . implode(', ', array_fill(0, count($ids), '?')) . ')' , array_merge(array(Message::SENT_TYPE_SENDING), $ids));
		}
		return $messages;
	}
	/**
	 * logging the message;
	 * 
	 * @param string $message
	 * @param string $funcName
	 * 
	 * @return UDate
	 */
	private static function _log($message, $funcName)
	{
		echo ($now = new UDate()) . "::$funcName::" . $message . "\n"; 
		return $now;
	}
}

Core::setUser(UserAccount::get(UserAccount::ID_SYSTEM_ACCOUNT));
MessageSender::run();