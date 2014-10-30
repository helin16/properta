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
        parent::__loadDaoMap();
        DaoMap::createUniqueIndex('name');
        DaoMap::commit();
    }
    /**
     * overload the get function from parent
     * 
     * @param int $id The id of the role
     * 
     * @return NULL
     */
    public static function get($id)
    {
    	if(!self::cacheExsits($id))
    		self::addCache($id, parent::get($id));
    	return self::getCache($id);
    }
}
?>
