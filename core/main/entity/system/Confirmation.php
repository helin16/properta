<?php
/** Confirmation Entity
 *
 * @package    Core
 * @subpackage Entity
 * @author     lhe<helin16@gmail.com>
 */
class Confirmation extends BaseEntityAbstract
{
	const TYPE_SYS = 'SYSTEM';
	/**
	 * How many hours before this confirmation expiries
	 * 
	 * @var int
	 */
	const EXPIRY_HOURS = 48;
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
	 * The comments of the confirmation
	 * 
	 * @var string
	 */
	private $comments;
	/**
	 * The type of the confirmation
	 * 
	 * @var string
	 */
	private $type;
	/**
	 * The identifier of that confirmation
	 * 
	 * @var string
	 */
	private $sKey;
	/**
	 * The expiry time
	 * 
	 * @var UDate
	 */
	private $expiryTime;
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
	 * @return Confirmation
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
	 * @return Confirmation
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
	 * @return Confirmation
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
	 * @return Confirmation
	 */
	public function setType($value) 
	{
	    $this->type = $value;
	    return $this;
	}
	/**
	 * Getter for the sKey
	 * 
	 * @return string
	 */
	public function getSKey() 
	{
	    return $this->sKey;
	}
	/**
	 * Setter for the SKey
	 * 
	 * @param string $value The skey
	 * 
	 * @return Confirmation
	 */
	public function setSKey($value) 
	{
	    $this->sKey = $value;
	    return $this;
	}
	/**
	 * Getter for expiryTime
	 *
	 * @return UDate
	 */
	public function getExpiryTime() 
	{
		if (is_string($this->expiryTime))
			$this->expiryTime = new UDate($this->expiryTime);
	    return $this->expiryTime;
	}
	/**
	 * Setter for expiryTime
	 *
	 * @param string $value The expiryTime
	 *
	 * @return Confirmation
	 */
	public function setExpiryTime($value) 
	{
	    $this->expiryTime = $value;
	    return $this;
	}
	/**
	 * Getting the entity
	 * 
	 * @return BaseEntityAbstract
	 * @throws Exception
	 * @throws EntityException
	 */
	public function getEntity()
	{
		$class = trim($this->getEntityName());
		try {
			if(!class_exists($class))
				throw new Exception();
		} catch (Exception $ex) {
			return null;
		}
		if(!($entity = $class::get(trim($this->getEntityId()))) instanceof ConfirmEntityAbstract || !($confirm = $entity->getConfirmation()) instanceof Confirmation)
			return null;
		if(trim($confirm->getId()) !== trim($this->getId()))
			return null;
		return $entity;
	}
	/**
	 * (non-PHPdoc)
	 * @see BaseEntityAbstract::preSave()
	 */
	public function preSave()
	{
		if(trim($this->getSKey()) === '')
			$this->setSKey(StringUtilsAbstract::getRandKey(trim($this->getEntityName()) . trim($this->getEntityId()) . trim(new UDate())));
		if(trim($this->getExpiryTime()) === '')
		{
			$expiryTime = new UDate();
			$expiryTime->modify('+' . self::EXPIRY_HOURS . ' hour');
			$this->setExpiryTime(trim($expiryTime));
		}
	}
	/**
	 * (non-PHPdoc)
	 * @see BaseEntity::__loadDaoMap()
	 */
	public function __loadDaoMap()
	{
		DaoMap::begin($this, 'log');
	
		DaoMap::setStringType('sKey','varchar', 32);
		DaoMap::setStringType('type','varchar', 20);
		DaoMap::setIntType('entityId');
		DaoMap::setStringType('entityName','varchar', 100);
		DaoMap::setStringType('comments','varchar', 255);
		DaoMap::setDateType('expiryTime');
	
		parent::__loadDaoMap();
	
		DaoMap::createIndex('sKey');
		DaoMap::createIndex('entityId');
		DaoMap::createIndex('entityName');
		DaoMap::createIndex('type');
	
		DaoMap::commit();
	}
	/**
	 * confirming the entity
	 * 
	 * @throws EntityException
	 * 
	 * @return ConfirmEntityAbstract
	 */
	public function confirm()
	{
		if(!($entity = $this->getEntity()) instanceof BaseEntityAbstract)
			throw new EntityException('The entity you are trying to confirm is not found.');
		$entity->setConfirmation(null)
			->setActive(true)
			->save()
			->addLog(Log::TYPE_SYS, 'Confirmed(=' . $this->getSKey() . ') ' . get_class($entity) . '(ID=' . trim($entity->getId()) . ').');
		$this->setActive(false)->save();
		return $entity;
	}
	/**
	 * creating a confirmation
	 * 
	 * @param ConfirmEntityAbstract  $entityId
	 * @param string                 $msg
	 * @param string                 $type
	 * @param string                 $comments
	 * 
	 * @return Confirmation
	 */
	public static function create(ConfirmEntityAbstract &$entity, $type, $comments = '')
	{
		$entityName = get_class($entity);
		$entityId = trim($entity->getId());
		$confirm = new Confirmation();
		$confirm->setEntityId($entityId)
			->setEntityName($entityName)
			->setType($type)
			->setComments($comments)
			->save()
			->addLog(Log::TYPE_SYS, ($msg = 'Confirmation for ' . $entityName . '(ID=' . $entityId . ') is created with expiry:' . trim($confirm->getExpiryTime()) . '(UTC)'));
		$entity->setConfirmation($confirm)
			->setActive(false)
			->save()
			->addLog(Log::TYPE_SYS, $msg);
		return $entity;
	}
	/**
	 * Getting Confirmation by the skey
	 * 
	 * @param string $key
	 * 
	 * @return NULL|Confirmation
	 */
	public static function getBySkeyNotExpired($key)
	{
		$items = self::getAllByCriteria('skey = ? and expiryTime >= NOW()', array(trim($key)), true, 1, 1);
		return count($items) > 0 ? $items[0] : null;
	}
}