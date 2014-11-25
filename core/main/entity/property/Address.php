<?php
/** Address Entity
 *
 * @package    Core
 * @subpackage Entity
 * @author     lhe<helin16@gmail.com>
 */
class Address extends BaseEntityAbstract
{
	/**
	 * The key of the address
	 * 
	 * @var string
	 */
	private $sKey;
	/**
	 * The street of the address
	 * 
	 * @var string
	 */
	private $street;
	/**
	 * The city name of the address
	 * 
	 * @var string
	 */
	private $city;
	/**
	 * The contact name of the address
	 * 
	 * @var string
	 */
	private $region;
	/**
	 * The postCode of the address
	 * 
	 * @var string
	 */
	private $postCode;
	/**
	 * The country of the address
	 * 
	 * @var string
	 */
	private $country;
	/**
	 * Getter for key
	 *
	 * @return string
	 */
	public function getSKey() 
	{
	    return $this->sKey;
	}
	/**
	 * Setter for key
	 *
	 * @param string $value The key
	 *
	 * @return Address
	 */
	public function setSKey($value) 
	{
	    $this->sKey = $value;
	    return $this;
	}
	
	/**
	 * Getter for street
	 *
	 * @return string
	 */
	public function getStreet() 
	{
	    return $this->street;
	}
	/**
	 * Setter for street
	 *
	 * @param string $value The street
	 *
	 * @return Address
	 */
	public function setStreet($value) 
	{
	    $this->street = $value;
	    return $this;
	}
	/**
	 * Getter for city
	 *
	 * @return string
	 */
	public function getCity() 
	{
	    return $this->city;
	}
	/**
	 * Setter for city
	 *
	 * @param string $value The city
	 *
	 * @return Address
	 */
	public function setCity($value) 
	{
	    $this->city = $value;
	    return $this;
	}
	/**
	 * Getter for region
	 *
	 * @return string
	 */
	public function getRegion() 
	{
	    return $this->region;
	}
	/**
	 * Setter for region
	 *
	 * @param string $value The region
	 *
	 * @return Address
	 */
	public function setRegion($value) 
	{
	    $this->region = $value;
	    return $this;
	}
	/**
	 * Getter for country
	 *
	 * @return 
	 */
	public function getCountry() 
	{
	    return $this->country;
	}
	/**
	 * Setter for country
	 *
	 * @param string $value The country
	 *
	 * @return Address
	 */
	public function setCountry($value) 
	{
	    $this->country = $value;
	    return $this;
	}
	/**
	 * Getter for postCode
	 *
	 * @return string
	 */
	public function getPostCode() 
	{
	    return $this->postCode;
	}
	/**
	 * Setter for postCode
	 *
	 * @param string $value The postCode
	 *
	 * @return Address
	 */
	public function setPostCode($value) 
	{
	    $this->postCode = $value;
	    return $this;
	}
	/**
	 * (non-PHPdoc)
	 * @see BaseEntityAbstract::__toString()
	 */
	public function __toString()
	{
		return trim($this->getStreet() . ', ' . $this->getCity() . ' ' . $this->getRegion() . ' ' . $this->getCountry() . ' ' . $this->getPostCode() );
	}
	/**
	 * (non-PHPdoc)
	 * @see BaseEntityAbstract::preSave()
	 */
	public function preSave()
	{
		$this->setSKey(trim(Address::genKey($this->street, $this->city, $this->region, $this->country, $this->postCode)));
	}
	/**
	 * (non-PHPdoc)
	 * @see BaseEntityAbstract::getJson()
	 */
	public function getJson($extra = '', $reset = false)
	{
		$array = array();
		if(!$this->isJsonLoaded($reset))
		{
			$array['full'] = trim($this);
		}
		return parent::getJson($array, $reset);
	}
	/**
	 * (non-PHPdoc)
	 * @see BaseEntity::__loadDaoMap()
	 */
	public function __loadDaoMap()
	{
		DaoMap::begin($this, 'addr');
	
		DaoMap::setStringType('sKey','varchar', 32);
		DaoMap::setStringType('street','varchar', 100);
		DaoMap::setStringType('city','varchar', 20);
		DaoMap::setStringType('region','varchar', 20);
		DaoMap::setStringType('country','varchar', 20);
		DaoMap::setStringType('postCode','varchar', 10);
	
		parent::__loadDaoMap();
	
		DaoMap::createIndex('skey');
		DaoMap::createIndex('city');
		DaoMap::createIndex('region');
		DaoMap::createIndex('country');
		DaoMap::createIndex('postCode');
	
		DaoMap::commit();
	}
	/**
	 * Creating a address object
	 *
	 * @param string $street       The street line of the address
	 * @param string $city         The city of the address
	 * @param string $region       The region/state of the address
	 * @param string $country      The country of the address
	 * @param string $postCode     The postCode of the address
	 *
	 * @return Address
	 */
	public static function create($street, $city, $region, $country, $postCode)
	{
		$key = self::genKey($street, $city, $region, $country, $postCode);
		if(self::getByKey($key) instanceof Address)
			throw new EntityException('Such an address exsits!');
		$obj = new Address();
		return $obj->setStreet($street)
			->setCity($city)
			->setRegion($region)
			->setCountry($country)
			->setPostCode($postCode)
			->save()
			->addLog(Log::TYPE_SYS, 'Created (' . trim($obj) . ') with ID=' . $obj->getSKey() . '.', __CLASS__ . '::' . __FUNCTION__);
	}
	/**
	 * Generating the key for an address
	 * 
	 * @param string $street       The street line of the address
	 * @param string $city         The city of the address
	 * @param string $region       The region/state of the address
	 * @param string $country      The country of the address
	 * @param string $postCode     The postCode of the address
	 * 
	 * @return string
	 */
	public static function genKey($street, $city, $region, $country, $postCode)
	{
		return md5(trim($street) . trim($city) . trim($region) . trim($country) . trim($postCode));
	}
	/**
	 * Getting a address by key
	 *
	 * @param string $key The unique key for an address
	 *
	 * @return Ambigous <NULL, unknown>
	 */
	public static function getByKey($key)
	{
		$items = self::getAllByCriteria('`sKey` = ?', array(trim($key)), true, 1, 1);
		return count($items) > 0 ? $items[0] : null;
	}
}