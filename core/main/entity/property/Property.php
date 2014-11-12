<?php
/**
 * Property Entity
 *
 * @package    Core
 * @subpackage Entity
 * @author     lhe<helin16@gmail.com>
 */
class Property extends BaseEntityAbstract
{
	/**
	 * The description of the property
	 * 
	 * @var string
	 */
	private $description;
	/**
	 * The unique key of the property for loading from url
	 * 
	 * @var string
	 */
	private $pKey;
	/**
	 * The number of rooms
	 * 
	 * @var int
	 */
	private $noOfRoom;
	/**
	 * the number of car spaces
	 * 
	 * @var int
	 */
	private $noOfCars;
	/**
	 * The number of bathrooms
	 * 
	 * @var int
	 */
	private $noOfBaths;
	/**
	 * The address of the property
	 * 
	 */
	protected $address = null;
	/**
	 * Getter for description
	 *
	 * @return string
	 */
	public function getDescription() 
	{
	    return $this->description;
	}
	/**
	 * Setter for description
	 *
	 * @param string $value The description
	 *
	 * @return Property
	 */
	public function setDescription($value) 
	{
	    $this->description = $value;
	    return $this;
	}
	/**
	 * Getter for address
	 *
	 * @return Address
	 */
	public function getAddress() 
	{
		$this->loadManyToOne('address');
	    return $this->address;
	}
	/**
	 * Setter for address
	 *
	 * @param address $value The address
	 *
	 * @return Property
	 */
	public function setAddress($value) 
	{
	    $this->address = $value;
	    return $this;
	}
	
	/**
	 * Getter for key
	 *
	 * @return string
	 */
	public function getPkey() 
	{
	    return $this->pKey;
	}
	/**
	 * Setter for key
	 *
	 * @param string $value The key
	 *
	 * @return Property
	 */
	public function setpKey($value) 
	{
	    $this->pKey = $value;
	    return $this;
	}
	/**
	 * Getter for noOfRoom
	 *
	 * @return int
	 */
	public function getNoOfRoom() 
	{
	    return $this->noOfRoom;
	}
	/**
	 * Setter for noOfRoom
	 *
	 * @param int $value The noOfRoom
	 *
	 * @return Property
	 */
	public function setNoOfRoom($value) 
	{
	    $this->noOfRoom = $value;
	    return $this;
	}
	/**
	 * Getter for noOfCars
	 *
	 * @return int
	 */
	public function getNoOfCars() 
	{
	    return $this->noOfCars;
	}
	/**
	 * Setter for noOfCars
	 *
	 * @param int $value The noOfCars
	 *
	 * @return Property
	 */
	public function setNoOfCars($value) 
	{
	    $this->noOfCars = $value;
	    return $this;
	}
	/**
	 * Getter for noOfBaths
	 *
	 * @return int
	 */
	public function getNoOfBaths() 
	{
	    return $this->noOfBaths;
	}
	/**
	 * Setter for noOfBaths
	 *
	 * @param int $value The noOfBaths
	 *
	 * @return Property
	 */
	public function setNoOfBaths($value)
	{
	    $this->noOfBaths = $value;
	    return $this;
	}
    /**
     * (non-PHPdoc)
     * @see BaseEntity::__toString()
     */
    public function __toString()
    {
        if(($name = trim($this->getName())) !== '')
            return $name;
        return parent::__toString();
    }
    /**
     * (non-PHPdoc)
     * @see BaseEntityAbstract::preSave()
     */
    public function preSave()
    {
    	parent::preSave();
    	if(trim($this->getKey()) === '')
    		$this->setKey(md5(trim($this->getAddress()) . microtime() . rand(0, PHP_INT_MAX)));
    }
    /**
     * Getting the relationships for a user
     * 
     * @param UserAccount $user
     * @param Role        $role
     * @param bool        $activeOnly
     * @param int         $pageNo
     * @param int         $pageSize
     * @param array       $orderBy
     * @param array       $stats
     * 
     * @throws CoreException
     * @return Ambigous <Ambigous, multitype:, multitype:BaseEntityAbstract >
     */
    public function getRelationships(UserAccount $user, Role $role = null, $activeOnly = true, $pageNo = null, $pageSize = DaoQuery::DEFAUTL_PAGE_SIZE, $orderBy = array(), &$stats = array())
    {
    	return PropertyRel::getRelationships($this, $user, $role, $activeOnly, $pageNo, $pageSize, $orderBy, $stats);
    }
    /**
     * (non-PHPdoc)
     * @see BaseEntity::__loadDaoMap()
     */
    public function __loadDaoMap()
    {
        DaoMap::begin($this, 'pro');
        DaoMap::setStringType('pKey', 'varchar', 32);
        DaoMap::setStringType('description', 'text');
        DaoMap::setManyToOne('address', 'Address', 'pro_addr', true);
        DaoMap::setIntType('noOfRooms');
        DaoMap::setIntType('noOfCars');
        DaoMap::setIntType('noOfBaths');
        parent::__loadDaoMap();
        
        DaoMap::createUniqueIndex('pKey');
        DaoMap::createIndex('noOfRooms');
        DaoMap::createIndex('noOfCars');
        DaoMap::createIndex('noOfBaths');
        DaoMap::commit();
    }
    /**
     * Getting a property by key
     * 
     * @param string $key The unique key for a property
     * 
     * @return Ambigous <NULL, unknown>
     */
    public static function getPropertyByKey($key)
    {
    	$items = self::getAllByCriteria('`pKey` = ?', array(trim($key)), true, 1, 1);
    	return count($items) > 0 ? $items[0] : null;
    }
}
?>
