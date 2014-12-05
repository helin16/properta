<?php
/**
 * Role Entity
 *
 * @package    Core
 * @subpackage Entity
 * @author     lhe<helin16@gmail.com>
 */
class Role extends BaseEntityAbstract
{
    /**
     * ID the TENANT role
     * 
     * @var int
     */
    const ID_TENANT = 40;
    /**
     * ID the Agent role
     * 
     * @var int
     */
    const ID_AGENT = 41;
    /**
     * ID the OWNER role
     * 
     * @var int
     */
    const ID_OWNER = 42;
    /**
     * The name of the role
     * @var string
     */
    private $name;
    /**
     * getter Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * setter Name
     *
     * @param string $Name The name of the role
     *
     * @return Role
     */
    public function setName($Name)
    {
        $this->name = $Name;
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
        DaoMap::begin($this, 'r');
        DaoMap::setStringType('name', 'varchar');
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
    /**
     * Get Roles for a property
     * 
     * @param Property $property
     * @param Person   $person
     * 
     * @return multitype:Role
     */
    public static function getPropertyRoles(Property $property, Person $person)
    {
    	$rels = PropertyRel::getRelationships($property, $person);
    	return array_unique(array_map(create_function('$a', 'return $a->getRole();'), $rels));
    }
}
?>
