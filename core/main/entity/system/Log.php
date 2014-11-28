<?php
/** Log Entity
 *
 * @package    Core
 * @subpackage Entity
 * @author     lhe<helin16@gmail.com>
 */
class Log extends BaseEntityAbstract
{
	const TYPE_SYS = 'SYSTEM';
	/**
	 * caching the transid
	 * 
	 * @var string
	 */
	private static $_transId = '';
	/**
	 * The id of the entity
	 * 
	 * @var int
	 */
	private $entityId;
	/**
	 * The entity name
	 * 
	 * @var string
	 */
	private $entityName;
	/**
	 * The comments of the log
	 * 
	 * @var string
	 */
	private $comments;
	/**
	 * The type of the log
	 * 
	 * @var string
	 */
	private $type;
	/**
	 * The identifier of that transation
	 * 
	 * @var string
	 */
	private $transId;
	/**
	 * The name of the function
	 * 
	 * @var string
	 */
	private $funcName = '';
	/**
	 * Getter for entityId
	 */
	public function getEntityId() 
	{
	    return $this->entityId;
	}
	/**
	 * Setter of the log
	 * 
	 * @param idt $value The id of entity
	 * 
	 * @return Log
	 */
	public function setEntityId($value) 
	{
	    $this->entityId = $value;
	    return $this;
	}
	/**
	 * Getter for the entity name
	 * 
	 * @return string
	 */
	public function getEntityName() 
	{
	    return $this->entityName;
	}
	/**
	 * Setter for the entity name
	 * 
	 * @param string $value The name of the entity
	 * 
	 * @return Log
	 */
	public function setEntityName($value) 
	{
	    $this->entityName = $value;
	    return $this;
	}
	/**
	 * Getter for the comments
	 * 
	 * @return string
	 */
	public function getComments() 
	{
	    return $this->comments;
	}
	/**
	 * Setter for the comments
	 * 
	 * @param string $value The comments
	 * 
	 * @return Log
	 */
	public function setComments($value)
	{
	    $this->comments = $value;
	    return $this;
	}
	/**
	 * Getter for the type
	 * 
	 * @return string
	 */
	public function getType() 
	{
	    return $this->type;
	}
	/**
	 * Setter for the type
	 * 
	 * @param string $value The type of the log
	 * 
	 * @return Log
	 */
	public function setType($value) 
	{
	    $this->type = $value;
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
	 * Getter for the funcName
	 * 
	 * @return string
	 */
	public function getFuncName() 
	{
	    return $this->funcName;
	}
	/**
	 * Setter for the funcName
	 * 
	 * @param string $value The name of the function
	 * 
	 * @return Log
	 */
	public function setFuncName($value) 
	{
	    $this->funcName = $value;
	    return $this;
	}
	/**
	 * (non-PHPdoc)
	 * @see BaseEntityAbstract::__toString()
	 */
	public function __toString()
	{
		return $this->getFuncName() . ': ' . $this->getMsg();
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
	 * @see BaseEntity::__loadDaoMap()
	 */
	public function __loadDaoMap()
	{
		DaoMap::begin($this, 'log');
	
		DaoMap::setStringType('transId','varchar', 32);
		DaoMap::setStringType('type','varchar', 20);
		DaoMap::setIntType('entityId');
		DaoMap::setStringType('entityName','varchar', 100);
		DaoMap::setStringType('funcName','varchar', 100);
		DaoMap::setStringType('comments','varchar', 255);
	
		parent::__loadDaoMap();
	
		DaoMap::createIndex('transId');
		DaoMap::createIndex('entityId');
		DaoMap::createIndex('entityName');
		DaoMap::createIndex('type');
		DaoMap::createIndex('funcName');
	
		DaoMap::commit();
	}
	/**
	 * Logging
	 * 
	 * @param int     $entityId
	 * @param string  $entityName
	 * @param string  $msg
	 * @param string  $type
	 * @param string  $comments
	 * @param string  $funcName
	 * 
	 * @return string The transId
	 */
	public static function logging($entityId, $entityName, $type, $comments = '', $funcName = '')
	{
		$className = __CLASS__;
		$log = new $className();
		$log->setEntityId($entityId)
			->setEntityName($entityName)
			->setType($type)
			->setComments($comments)
			->setFuncName($funcName)
			->save();
		return $log;
	}
	/**
	 * Getting the lastest group of logs
	 * 
	 * @param int   $pageNo
	 * @param int   $pageSize
	 * @param array $orderBy
	 * 
	 * @return multitype:Log
	 */
	public static function getLatestLogs($pageNo = null, $pageSize = DaoQuery::DEFAUTL_PAGE_SIZE, $orderBy = array(), $activeOnly = true, &$stats = array())
	{
		return self::getAllByCriteria('transId = ?', array(self::$_transId), $activeOnly, $pageNo, $pageSize, $orderBy, $stats);
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
	 * Logging the entity
	 * 
	 * @param BaseEntityAbstract $entity
	 * @param string             $msg
	 * @param string             $type
	 * @param string             $comments
	 * 
	 * @return string The transId
	 */
	public static function LogEntity(BaseEntityAbstract $entity, $type, $comments = '', $funcName = '')
	{
		return self::logging($entity->getId(), get_class($entity), $type, $comments, $funcName);
	}
}