<?php
/**
 * Property Relationship Entity
 *
 * @package    Core
 * @subpackage Entity
 * @author     lhe<helin16@gmail.com>
 */
class PropertyRel extends BaseEntityAbstract
{
	/**
	 * The property for this relationship
	 * 
	 * @var Property
	 */
	protected $property;
	/**
	 * The role of the relationship
	 * 
	 * @var Role
	 */
	protected $role;
	/**
	 * The user of the UserAccount
	 * 
	 * @var UserAccount
	 */
	protected $userAccount;
	/**
	 * Getter for property
	 *
	 * @return Property
	 */
	public function getProperty() 
	{
		$this->loadManyToOne('property');
	    return $this->property;
	}
	/**
	 * Setter for property
	 *
	 * @param Property $value The property
	 *
	 * @return PropertyRel
	 */
	public function setProperty($value)
	{
	    $this->property = $value;
	    return $this;
	}
	/**
	 * Getter for role
	 *
	 * @return Role
	 */
	public function getRole() 
	{
		$this->loadManyToOne('role');
	    return $this->role;
	}
	/**
	 * Setter for role
	 *
	 * @param Role $value The role
	 *
	 * @return PropertyRel
	 */
	public function setRole($value) 
	{
	    $this->role = $value;
	    return $this;
	}
	/**
	 * Getter for userAccount
	 *
	 * @return UserAccount
	 */
	public function getUserAccount() 
	{
		$this->loadManyToOne('userAccount');
	    return $this->userAccount;
	}
	/**
	 * Setter for userAccount
	 *
	 * @param UserAccount $value The userAccount
	 *
	 * @return PropertyRel
	 */
	public function setUserAccount(UserAccount $value) 
	{
	    $this->userAccount = $value;
	    return $this;
	}
    /**
     * (non-PHPdoc)
     * @see BaseEntity::__loadDaoMap()
     */
    public function __loadDaoMap()
    {
        DaoMap::begin($this, 'pro_rel');
        
        DaoMap::setManyToOne('property', 'Property');
        DaoMap::setManyToOne('role', 'Role');
        DaoMap::setManyToOne('userAccount', 'UserAccount');
        
        parent::__loadDaoMap();
        DaoMap::commit();
    }
}
?>
