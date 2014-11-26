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
    /**
     * Getting the relationships for a user
     * 
     * @param Property    $property
     * @param UserAccount $user
     * @param Role        $role
     * @param bool        $activeOnly
     * @param int         $pageNo
     * @param int         $pageSize
     * @param array       $orderBy
     * @param array       $stats
     * 
     * @throws CoreException
     * @return Ambigous <Ambigous, multitype:, multitype:BaseEntityAbstract >
     */
    public static function getRelationships(Property $property = null, UserAccount $user = null, Role $role = null, $activeOnly = true, $pageNo = null, $pageSize = DaoQuery::DEFAUTL_PAGE_SIZE, $orderBy = array(), &$stats = array())
    {
    	if(!$property instanceof Property && !$user instanceof UserAccount)
    		throw new CoreException('At least one of the search criterial should be provided: property or user');
    	$where = array();
    	$param = array();
    	if($property instanceof Property)
    	{
    		$where[]= 'propertyId = ?';
    		$param[] = $property->getId();
    	}
    	if($user instanceof UserAccount)
    	{
    		$where[] = 'userAccountId = ?';
    		$param[] = $user->getId();
    	}
    	if($role instanceof Role)
    	{
    		$where[] = 'roleId = ?';
    		$param[] = $role->getId();
    	}
    	return self::getAllByCriteria(implode(' AND ', $where), $param, $activeOnly, $pageNo, $pageSize, $orderBy, $stats);
    }
    /**
     * Creating a propertrel to a user
     * 
     * @param Property    $property
     * @param UserAccount $user
     * @param Role        $role
     * 
     * @return PropertyRel
     */
    public static function create(Property $property, UserAccount $user, Role $role)
    {
    	$exsitingRels = self::getAllByCriteria('propertyId = ? and userAccountId = ? and roleId = ?', array($property->getId(), $user->getId(), $role->getId()), true, 1, 1);
    	if(count($exsitingRels) > 0)
    		return $exsitingRels[0];
    	$msg = 'User(' . $user->getFirstName() . ') is now a ' . $role->getName() . ' of Property(ID=' . $property->getSKey() . ').';
    	$rel = new PropertyRel();
    	return $rel->setProperty($property->addLog(Log::TYPE_SYS, $msg, __CLASS__ . '::' . __FUNCTION__))
    		->setUserAccount($user)
    		->setRole($role)
    		->save()
    		->addLog(Log::TYPE_SYS, $msg, __CLASS__ . '::' . __FUNCTION__);
    }
    /**
     * deleting the property relationships
     * 
     * @param Property    $property
     * @param UserAccount $user
     * @param Role        $role
     */
    public static function delete(Property $property, UserAccount $user, Role $role = null)
    {
    	$where = 'propertyId = ? and userAccountId = ?';
    	$params = array($property->getId(), $user->getId());
    	if($role instanceof Role)
    	{
    		$where .= ' AND roleId = ?';
    		$params[] = $role->getId();
    	}
    	self::updateByCriteria('active = 0', $where, $params);
    }
}
?>
