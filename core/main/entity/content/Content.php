<?php
/**
 * Content Entity - The file holder
 *
 * @package    Core
 * @subpackage Entity
 * @author     lhe<helin16@gmail.com>
 */
class Content extends BaseEntityAbstract
{
    /**
     * The content of the file
     * 
     * @var string
     */
    private $content;
    /**
     * Getter for content
     *
     * @return string
     */
    public function getContent() 
    {
        return $this->content;
    }
    /**
     * Setter for content
     *
     * @param string $value The content
     *
     * @return Role
     */
    public function setContent($value) 
    {
        $this->content = $value;
        return $this;
    }
    /**
     * (non-PHPdoc)
     * @see BaseEntityAbstract::preSave()
     */
    public function preSave()
    {
    	if(intval(strlen($this->getContent())) > intval($this->getMaxSize()))
    		throw new EntityException(array('max' => $this->getMaxSize()), 'entity_content_max_size');
    }
    /**
     * Getting max size of the content that system can store in bytes
     * 
     * @return number
     */
    public static function getMaxSize()
    {
    	$key = 'maxContent';
    	if(!self::cacheExsits($key))
    	{
	    	$sql = 'SELECT character_maximum_length FROM information_schema.columns WHERE  table_schema = :db AND table_name = :tbl AND column_name = :col limit 1';
	    	$results = Dao::getResultsNative($sql, array('db' => Config::get('Database', 'DB'), 'tbl' => strtolower(__CLASS__), 'col' => 'content'), PDO::FETCH_ASSOC);
	    	self::addCache($key, count($results) === 0 ? 0 : $results[0]['character_maximum_length']);
    	} 
    	return self::getCache($key);
    }
    /**
     * (non-PHPdoc)
     * @see BaseEntity::__toString()
     */
    public function __toString()
    {
        return $this->getContent();
    }
    /**
     * (non-PHPdoc)
     * @see BaseEntity::__loadDaoMap()
     */
    public function __loadDaoMap()
    {
        DaoMap::begin($this, 'cont');
        DaoMap::setStringType('content', 'longtext');
        parent::__loadDaoMap();
        DaoMap::commit();
    }
    /**
     * Creating a content
     * 
     * @param string $content The string content of the file
     * 
     * @return Content
     */
    public static function create($content)
    {
    	$class = get_called_class();
    	$item = new $class();
    	return $item->setContent($content);
    }
}
?>
