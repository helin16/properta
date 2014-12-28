<?php
/** Tag Entity
 *
 * @package    Core
 * @subpackage Entity
 * @author     lhe<helin16@gmail.com>
 */
class EntityTag extends BaseEntityAbstract
{
	const TYPE_SYS = 'SYSTEM';
	const TYPE_USER = 'USER';
	/**
	 * The id of the entity
	 * 
	 * @var int
	 */
	private $entityId;
	/**
	 * The entity tag
	 * 
	 * @var string
	 */
	private $entityName;
	/**
	 * The type of the log
	 * 
	 * @var string
	 */
	private $type;
	/**
	 * The tag of EntityName
	 * 
	 * @var Tag
	 */
	protected $tag;
	/**
	 * Getter for entityId
	 */
	public function getEntityId() 
	{
	    return $this->entityId;
	}
	/**
	 * Setter of the EntityId
	 * 
	 * @param idt $value The id of entity
	 * 
	 * @return EntityTag
	 */
	public function setEntityId($value) 
	{
	    $this->entityId = $value;
	    return $this;
	}
	/**
	 * Getter for the entity tag
	 * 
	 * @return string
	 */
	public function getEntityName() 
	{
	    return $this->entityName;
	}
	/**
	 * Setter for the entity tag
	 * 
	 * @param string $value The tag of the entity
	 * 
	 * @return EntityTag
	 */
	public function setEntityName($value) 
	{
	    $this->entityName = $value;
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
	 * @return EntityTag
	 */
	public function setType($value) 
	{
	    $this->type = $value;
	    return $this;
	}
	/**
	 * Getter for the tag
	 * 
	 * @return Tag
	 */
	public function getTag() 
	{
		$this->loadManyToOne('tag');
	    return $this->tag;
	}
	/**
	 * Setter for the tag
	 * 
	 * @param Tag $value The tag of the function
	 * 
	 * @return EntityTag
	 */
	public function setTag(Tag $value) 
	{
	    $this->tag = $value;
	    return $this;
	}
	/**
	 * (non-PHPdoc)
	 * @see BaseEntity::__loadDaoMap()
	 */
	public function __loadDaoMap()
	{
		DaoMap::begin($this, 'ent_tag');
	
		DaoMap::setStringType('type','varchar', 20);
		DaoMap::setIntType('entityId');
		DaoMap::setStringType('EntityName','varchar', 100);
		DaoMap::setManyToOne('tag','Tag', 'ent_tag_tag');
	
		parent::__loadDaoMap();
	
		DaoMap::createIndex('entityId');
		DaoMap::createIndex('EntityName');
		DaoMap::createIndex('type');
	
		DaoMap::commit();
	}
	/**
	 * creating a EntityName
	 * 
	 * @param int     $entityId
	 * @param string  $EntityName
	 * @param Tag     $tag
	 * @param string  $type
	 * 
	 * @return EntityTag
	 */
	public static function create($entityId, $EntityName, Tag $tag, $type = self::TYPE_SYS)
	{
		$tag = new EntityTag();
		$tag->setEntityId($entityId)
			->setEntityName($EntityName)
			->setType($type)
			->setTag($tag)
			->save();
		return $tag;
	}
	/**
	 * Tagging an entity
	 * 
	 * @param BaseEntityAbstract $entity
	 * @param string             $tagName
	 * @param string             $type
	 * 
	 * @return EntityTag
	 */
	public static function tagEntity(BaseEntityAbstract $entity, $tagName, $type = self::TYPE_SYS)
	{
		return self::create($entity->getId(), get_class($entity), Tag::create($tagName), $type);
	}
	/**
	 * remove tag of the entity
	 * 
	 * @param BaseEntityAbstract $entity
	 * @param string|null        $type
	 * @param string             $tagName
	 * 
	 * @return BaseEntityAbstract
	 */
	public static function rmTags(BaseEntityAbstract $entity, $type, $tagName)
	{
		$where = 'entityId = ? and entityName = ?';
		$params = array($entity->getId(), get_class($entity));
		if($type !== null) {
			$where .= ' AND type = ?';
			$params[] = trim($type);
		}
		if($tagName !== null && ($tag = Tag::getByName($tagName)) instanceof Tag) {
			$where .= ' AND tagId = ?';
			$params[] = $tag->getId();
		}
		self::updateByCriteria('active = 0', $where, $params);
		return $entity;
	}
	/**
	 * Getting all for an entity
	 * 
	 * @param BaseEntityAbstract $entity
	 * @param string             $type
	 * @param int                $pageNo
	 * @param int                $pageSize
	 * @param array              $orderBy
	 * @param array              $stats
	 * 
	 * @return multiple:EntityTag
	 */
	public static function getAllForEntity(BaseEntityAbstract $entity, $type = null, $pageNo = null, $pageSize = DaoQuery::DEFAUTL_PAGE_SIZE, $orderBy = array(), &$stats = array())
	{
		$where = 'entityId = ? and entityName = ?';
		$params = array($entity->getId(), get_class($entity));
		if(($type = trim($type)) !== '') {
			$where .= ' AND type = ?';
			$params[] = $type;
		}
		return self::getAllByCriteria($where, $params, true, $pageNo, $pageSize, $orderBy, $stats);
	}
}