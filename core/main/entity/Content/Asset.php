<?php
/**
 * Entity for tracking location of Asset assets in shared storage
 *
 * @package    Core
 * @subpackage Entity
 * @author     lhe<helin16@gmail.com>
 */
class Asset extends BaseEntityAbstract
{
	/**
	 * @var string
	 */
	private $assetId = '';
	/**
	 * @var string
	 */
	private $filename;
	/**
	 * @var string
	 */
	private $mimeType;
	/**
	 * The content of this asset
	 * 
	 * @var string
	 */
	protected $content;
	/**
	 * getter assetId
	 *
	 * @return string
	 */
	public function getAssetId()
	{
		return $this->assetId;
	}
	/**
	 * setter assetId
	 * 
	 * @param string $assetId The asset Id
	 * 
	 * @return Asset
	 */
	public function setAssetId($assetId)
	{
		$this->assetId = $assetId;
		return $this;
	}
	/**
	 * getter filename
	 *
	 * @return string
	 */
	public function getFilename()
	{
		return $this->filename;
	}
	/**
	 * setter filename
	 * 
	 * @param string $filename The filename of the asset
	 * 
	 * @return Asset
	 */
	public function setFilename($filename)
	{
		$this->filename = $filename;
		return $this;
	}
	/**
	 * getter mimeType
	 *
	 * @return string
	 */
	public function getMimeType()
	{
		return $this->mimeType;
	}
	/**
	 * setter mimeType
	 * 
	 * @param string $mimeType The mimeType
	 * 
	 * @return Asset
	 */
	public function setMimeType($mimeType)
	{
		$this->mimeType = $mimeType;
		return $this;
	}
	/**
	 * Getter for content
	 *
	 * @return Content
	 */
	public function getContent() 
	{
		$this->loadManyToOne('content');
	    return $this->content;
	}
	/**
	 * Setter for content
	 *
	 * @param Content $value The content
	 *
	 * @return Asset
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
		if(trim($this->getAssetId()) === '')
			$this->setAssetId(md5($filename . '::' . microtime()));
	}
	/**
	 * (non-PHPdoc)
	 * @see BaseEntityAbstract::__toString()
	 */
	public function __toString()
	{
	    return $this->getFilename();
	}
	/**
	 * (non-PHPdoc)
	 * @see HydraEntity::__loadDaoMap()
	 */
	public function __loadDaoMap()
	{
		DaoMap::begin($this, 'asset');
		
		DaoMap::setStringType('assetId', 'varchar', 32);
		DaoMap::setStringType('filename', 'varchar', 100);
		DaoMap::setStringType('mimeType', 'varchar', 50);
		DaoMap::setStringType('content');
		parent::__loadDaoMap();
		
		DaoMap::createUniqueIndex('assetId');
		DaoMap::commit();
	}
	/**
	 * Getting the Asset object
	 *
	 * @param string $assetId The assetid of the content
	 *
	 * @return Ambigous <unknown, array(HydraEntity), Ambigous, multitype:, string, multitype:Ambigous <multitype:, multitype:NULL boolean number string mixed > >
	 */
	public static function getAsset($assetId)
	{
		$content = self::getAllByCriteria('assetId = ?', array($assetId), false, 1, 1);
		return count($content) === 0 ? null : $content[0];
	}
	/**
	 * Remove an asset from the content server
	 *
	 * @param array $assetIds The assetids of the content
	 *
	 * @return bool
	 */
	public static function removeAssets(array $assetIds)
	{
		if(count($assetIds) === 0)
			return true;
		// Delete the item from the database
		self::deleteByCriteria('assetId in (' . implode(', ', array_fill(0, count($assetIds), '?')) . ')', $assetIds);
		return true;
	}
	/**
	 * Register a file with the Asset server and get its asset id
	 *
	 * @param string $filename The name of the file
	 * @param string $data     The data within that file we are trying to save
	 *
	 * @return string 32 char MD5 hash
	 */
	public static function registerAsset($filename, $dataOrFile)
	{
		if(!is_string($dataOrFile) && (!is_file($dataOrFile)))
			throw new CoreException(__CLASS__ . '::' . __FUNCTION__ . '() will ONLY take string to save!');
		
		$class = get_called_class();
		$asset = new $class();
		$asset->setFilename($filename)
			->setMimeType(StringUtilsAbstract::getMimeType($filename))
			->setContent(Content::create(is_file($dataOrFile) ? readfile($dataOrFile) : $dataOrFile))
			->save();
		return $asset;
	}
}

?>