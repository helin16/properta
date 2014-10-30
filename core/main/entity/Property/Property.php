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
     * @see BaseEntity::__loadDaoMap()
     */
    public function __loadDaoMap()
    {
        DaoMap::begin($this, 'pro');
        DaoMap::setStringType('description', 'text');
        DaoMap::setManyToOne('address', 'Address', 'pro_addr', true);
        parent::__loadDaoMap();
        DaoMap::createUniqueIndex('name');
        DaoMap::commit();
    }
}
?>
