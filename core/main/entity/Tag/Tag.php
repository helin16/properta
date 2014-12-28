<?php
/**
 * Tag Entity
 *
 * @package    Core
 * @subpackage Entity
 * @author     lhe<helin16@gmail.com>
 */
class Tag extends BaseEntityAbstract
{
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
        DaoMap::begin($this, 'tag');
        DaoMap::setStringType('name', 'varchar', 100);
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
     * overload the get function from parent
     * 
     * @param int $id The id of the role
     * 
     * @return NULL
     */
    public static function getByName($name)
    {
    	$key = md5($name);
    	if(!self::cacheExsits($key))
    	{
    		$tags = self::getAllByCriteria('name = ?', array(trim($name)), false, 1, 1);
    		self::addCache($key, (count($tags) === 0 ? null : $tags[0]));
    	}
    	return self::getCache($key);
    }
    /**
     * Creating a tag
     * 
     * @param string $name
     * 
     * @return Ambigous <BaseEntityAbstract, GenericDAO>
     */
    public static function create($name) 
    {
    	if (($tag = self::getByName($name)) instanceof Tag) {
    		if(intval($tag->getActive()) === 1)
    			return $tag;
    		return $tag->setActive(true)
    			->save();
    	}
    	
    	$tag = new Tag();
    	return $tag->setName($name)
    		->save();
    }
}
?>
