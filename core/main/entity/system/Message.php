<?php
class Message extends BaseEntityAbstract
{
	const TYPE_SYS = 'SYSTEM';
	const TYPE_USER = 'USER';
	
	const SENT_TYPE_NEW = 'NEW';
	const SENT_TYPE_SENDING = 'SENDING';
	const SENT_TYPE_SENT = 'SENT';
	/**
	 * caching the transid
	 *
	 * @var string
	 */
	private static $_transId = '';
	/**
	 * The message is send to
	 * 
	 * @var Person
	 */
	protected $to;
	/**
	 * The message is send from
	 * 
	 * @var Person
	 */
	protected $from;
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
	 * Whether the message has been read by the user
	 * 
	 * @var string
	 */
	private $isRead = false;
	/**
	 * The messge sending type: NEW, SENDING and SENT
	 * 
	 * @var string
	 */
	private $sendType = self::SENT_TYPE_NEW;
	/**
	 * The identifier of that transation
	 *
	 * @var string
	 */
	private $transId;
	/**
	 * Getter for to
	 *
	 * @return Person
	 */
	public function getTo() 
	{
		$this->loadManyToOne('to');
	    return $this->to;
	}
	/**
	 * Setter for to
	 *
	 * @param Person $value The to
	 *
	 * @return Message
	 */
	public function setTo(Person $value) 
	{
	    $this->to = $value;
	    return $this;
	}
	/**
	 * Getter for from
	 *
	 * @return Person
	 */
	public function getFrom() 
	{
		$this->loadManyToOne('from');
	    return $this->from;
	}
	/**
	 * Setter for from
	 *
	 * @param Person $value The from
	 *
	 * @return Message
	 */
	public function setFrom(Person $value) 
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
	 * @return Message
	 */
	public function setTransId($value)
	{
		$this->transId = $value;
		return $this;
	}
	/**
	 * Getter for the isRead
	 *
	 * @return bool
	 */
	public function getIsRead()
	{
		return $this->isRead;
	}
	/**
	 * Setter for the isRead
	 *
	 * @param bool $value The isRead
	 *
	 * @return Message
	 */
	public function setIsRead($value)
	{
		$this->isRead = $value;
		return $this;
	}
	/**
	 * Getter for the sendType
	 *
	 * @return string
	 */
	public function getSendType()
	{
		return $this->sendType;
	}
	/**
	 * Setter for the sendType
	 *
	 * @param bool $value The sendType
	 *
	 * @return Message
	 */
	public function setSendType($value)
	{
		$this->sendType = $value;
		return $this;
	}
	/**
	 * (non-PHPdoc)
	 * @see BaseEntityAbstract::preSave()
	 */
	public function preSave()
	{
		if(trim($this->getTransId()) === '')
			$this->setTransId(self::getTransKey());
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
	
		DaoMap::setBoolType('isRead');
		DaoMap::setStringType('sendType','varchar', 10);
		DaoMap::setManyToOne('to', 'Person');
		DaoMap::setManyToOne('from', 'Person');
		DaoMap::setStringType('type','varchar', 10);
		DaoMap::setStringType('subject','varchar', 100);
		DaoMap::setStringType('body','longtext');
		DaoMap::setStringType('transId','varchar', 32);
	
		parent::__loadDaoMap();
	
		DaoMap::createIndex('isRead');
		DaoMap::createIndex('sendType');
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
	 * @param Person  $from
	 * @param Person  $to
	 * @param unknown $type
	 * @param unknown $subject
	 * @param unknown $body
	 * 
	 * @return Message
	 */
	public static function create(Person $from, Person $to, $type, $subject, $body)
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