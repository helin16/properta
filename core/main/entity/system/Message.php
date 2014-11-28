<?php
class Message extends BaseEntityAbstract
{
	const TYPE_SYS = 'SYSTEM';
	const TYPE_USER = 'USER';
	/**
	 * caching the transid
	 *
	 * @var string
	 */
	private static $_transId = '';
	/**
	 * UserAccount the message is send to
	 * 
	 * @var UserAccount
	 */
	private $to;
	/**
	 * UserAccount the message is send from
	 * 
	 * @var UserAccount
	 */
	private $from;
	/**
	 * Type of the message: system or user
	 * 
	 * @var string
	 */
	private $type;
	/**
	 * The subject of the message
	 * 
	 * @var string
	 */
	private $subject;
	/**
	 * The body of the message
	 * 
	 * @var string
	 */
	private $body;
	/**
	 * The identifier of that transation
	 *
	 * @var string
	 */
	private $transId;
	/**
	 * Getter for to
	 *
	 * @return UserAccount
	 */
	public function getTo() 
	{
		$this->loadManyToOne('to');
	    return $this->to;
	}
	/**
	 * Setter for to
	 *
	 * @param UserAccount $value The to
	 *
	 * @return Message
	 */
	public function setTo(UserAccount $value) 
	{
	    $this->to = $value;
	    return $this;
	}
	/**
	 * Getter for from
	 *
	 * @return UserAccount
	 */
	public function getFrom() 
	{
		$this->loadManyToOne('from');
	    return $this->from;
	}
	/**
	 * Setter for from
	 *
	 * @param UserAccount $value The from
	 *
	 * @return Message
	 */
	public function setFrom(UserAccount $value) 
	{
	    $this->from = $value;
	    return $this;
	}
	/**
	 * Getter for type
	 *
	 * @return string
	 */
	public function getType() 
	{
	    return $this->type;
	}
	/**
	 * Setter for type
	 *
	 * @param string $value The type
	 *
	 * @return Message
	 */
	public function setType($value) 
	{
	    $this->type = $value;
	    return $this;
	}
	/**
	 * Getter for subject
	 *
	 * @return string
	 */
	public function getSubject() 
	{
	    return $this->subject;
	}
	/**
	 * Setter for subject
	 *
	 * @param string $value The subject
	 *
	 * @return Message
	 */
	public function setSubject($value) 
	{
	    $this->subject = $value;
	    return $this;
	}
	/**
	 * Getter for body
	 *
	 * @return string
	 */
	public function getBody() 
	{
	    return $this->body;
	}
	/**
	 * Setter for body
	 *
	 * @param string $value The body
	 *
	 * @return Message
	 */
	public function setBody($value) 
	{
	    $this->body = $value;
	    return $this;
	}
	/**
	 * Getter for the transId
	 *
	 * @return string
	 */
	public function getTransId()
	{
		return $this->transId;
	}
	/**
	 * Setter for the transId
	 *
	 * @param string $value The transId
	 *
	 * @return Log
	 */
	public function setTransId($value)
	{
		$this->transId = $value;
		return $this;
	}
	/**
	 * (non-PHPdoc)
	 * @see BaseEntityAbstract::__toString()
	 */
	public function __toString()
	{
		return 'Message for ' . $this->getTo() . ' from ' . $this->getFrom() . ': ' . $this->getSubject();
	}
	/**
	 * (non-PHPdoc)
	 * @see BaseEntity::__loadDaoMap()
	 */
	public function __loadDaoMap()
	{
		DaoMap::begin($this, 'msg');
	
		DaoMap::setManyToOne('to', 'UserAccount');
		DaoMap::setManyToOne('from', 'UserAccount');
		DaoMap::setStringType('type','varchar', 10);
		DaoMap::setStringType('subject','varchar', 100);
		DaoMap::setStringType('body','longtext');
		DaoMap::setStringType('transId','varchar', 32);
	
		parent::__loadDaoMap();
	
		DaoMap::createIndex('transId');
		DaoMap::createIndex('type');
		DaoMap::createIndex('subject');
	
		DaoMap::commit();
	}
	/**
	 * Getting the transid
	 *
	 * @param string $salt The salt of making the trans id
	 *
	 * @return string
	 */
	public static function getTransKey($salt = '')
	{
		if(trim(self::$_transId) === '')
			self::$_transId = StringUtilsAbstract::getRandKey($salt);
		return self::$_transId;
	}
	/**
	 * creating a message
	 * 
	 * @param UserAccount $from
	 * @param UserAccount $to
	 * @param unknown $type
	 * @param unknown $subject
	 * @param unknown $body
	 * 
	 * @return Message
	 */
	public static function create(UserAccount $from, UserAccount $to, $type, $subject, $body)
	{
		$entity = new Message();
		return $entity->setTo($to)
			->setFrom($from)
			->setType($type)
			->setSubject($subject)
			->setBody($body)
			->save();
	}
}