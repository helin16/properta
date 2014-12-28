<?php
/** Attachment Entity
 *
 * @package    Core
 * @subpackage Entity
 * @author     lhe<helin16@gmail.com>
 */
class Attachment extends BaseEntityAbstract
{
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
	 * The asset of the attachment
	 * 
	 * @var Asset
	 */
	protected $asset;
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
	 * @return Attachment
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
	 * @return Attachment
	 */
	public function setEntityName($value) 
	{
	    $this->entityName = $value;
	    return $this;
	}
	/**
	 * Getter for the tag
	 * 
	 * @return Asset
	 */
	public function getAsset() 
	{
		$this->loadManyToOne('asset');
	    return $this->asset;
	}
	/**
	 * Setter for the Asset
	 * 
	 * @param Asset $value The tag of the function
	 * 
	 * @return Attachment
	 */
	public function setAsset(Asset $value) 
	{
	    $this->asset = $value;
	    return $this;
	}
	/**
	 * (non-PHPdoc)
	 * @see BaseEntity::__loadDaoMap()
	 */
	public function __loadDaoMap()
	{
		DaoMap::begin($this, 'attachment');
	
		DaoMap::setIntType('entityId');
		DaoMap::setStringType('EntityName','varchar', 100);
		DaoMap::setManyToOne('asset','Asset', 'attachment_ass');
	
		parent::__loadDaoMap();
	
		DaoMap::createIndex('entityId');
		DaoMap::createIndex('EntityName');
	
		DaoMap::commit();
	}
	/**
	 * creating a Attachment
	 * 
	 * @param int     $entityId
	 * @param string  $EntityName
	 * @param Asset   $asset
	 * @param string  $type
	 * 
	 * @return EntityTag
	 */
	public static function create($entityId, $EntityName, Asset $asset)
	{
		$att = new Attachment();
		$att->setEntityId($entityId)
			->setEntityName($EntityName)
			->setAsset($asset)
			->save();
		return $att;
	}
	/**
	 * Getting the asset from asset or assetId
	 * 
	 * @param Mixed $assetOrAssetId
	 * 
	 * @return Asset|null
	 */
	private static function _getAsset($assetOrAssetId)
	{
		if($assetOrAssetId instanceof Asset)
			return $assetOrAssetId;
		if(is_string($assetOrAssetId) && ($asset = Asset::getAsset(trim($assetOrAssetId))) instanceof Asset)
			return $asset;
		return null;
	}
	/**
	 * attach to an entity
	 * 
	 * @param BaseEntityAbstract $entity
	 * @param string             $tagName
	 * @param mixed              $assetOrAssetId
	 * 
	 * @return EntityTag
	 */
	public static function attachToEntity(BaseEntityAbstract $entity, $assetOrAssetId)
	{
		if(!($asset = self::_getAsset($assetOrAssetId)) instanceof Asset)
			throw new EntityException(__CLASS__ . '::' . __FUNCTION__ . ' needs the 2nd param as an Asset or assetId.');
		return self::create($entity->getId(), get_class($entity), $asset);
	}
	/**
	 * Remove the attachment for an entity
	 * 
	 * @param BaseEntityAbstract $entity
	 * @param mixed              $assetOrAssetId  When null,  it will clear all attachment for that entity
	 * 
	 * @return BaseEntityAbstract
	 */
	public static function rmFromEntity(BaseEntityAbstract $entity, $assetOrAssetId)
	{
		if($assetOrAssetId === null)
			self::updateByCriteria('active = 0', 'entityId = ? and entityName = ?', array($entity->getId(), get_class($entity)));
		else if(($asset = self::_getAsset($assetOrAssetId)) instanceof Asset)
			self::updateByCriteria('active = 0', 'entityId = ? and entityName = ? and assetId = ?', array($entity->getId(), get_class($entity), $asset->getId()));
		return $entity;
	}
	/**
	 * Getting all for an entity
	 * 
	 * @param BaseEntityAbstract $entity
	 * @param int                $pageNo
	 * @param int                $pageSize
	 * @param array              $orderBy
	 * @param array              $stats
	 * 
	 * @return multiple:Attachment
	 */
	public static function getAllForEntity(BaseEntityAbstract $entity, $pageNo = null, $pageSize = DaoQuery::DEFAUTL_PAGE_SIZE, $orderBy = array(), &$stats = array())
	{
		return self::getAllByCriteria('entityId = ? and entityName = ?', array($entity->getId(), get_class($entity)), true, $pageNo, $pageSize, $orderBy, $stats);
	}
}