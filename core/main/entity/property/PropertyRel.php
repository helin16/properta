<?php
/**
 * Property Relationship Entity
 *
 * @package    Core
 * @subpackage Entity
 * @author     lhe<helin16@gmail.com>
 */
class PropertyRel extends ConfirmEntityAbstract
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
	 * The user of the person
	 * 
	 * @var Person
	 */
	protected $person;
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
	 * Getter for person
	 *
	 * @return Person
	 */
	public function getPerson() 
	{
		$this->loadManyToOne('person');
	    return $this->person;
	}
	/**
	 * Setter for person
	 *
	 * @param Person $value The person
	 *
	 * @return PropertyRel
	 */
	public function setPerson(Person $value) 
	{
	    $this->person = $value;
	    return $this;
	}
	public function postSave()
	{
		$message = 'Dear {roleName} of property: ' . $this->getProperty()->getAddress() . ', The user list is now changed by' . Core::getUser()->getFullName() . ':<br/><br />';
		if($this->getActive())
			$message .= 'A new User (' . $this->getPerson()->getFullName() . ', ' . $this->getPerson()->getEmail() . ') is now a ' . $this->getRole()->getName() . ' of this property';
		else
			$message .= 'User(' . $this->getPerson()->getFullName() . ', ' . $this->getPerson()->getFullName() . ') is no longer a ' . $this->getRole()->getName() . ' of this property.';
		
		//inform all the owners
		$owners = Person::getUsersForProperty($this->getProperty(), Role::get(Role::ID_OWNER));
		foreach($owners as $owner)
		{
			if($owner->getId() !== Core::getUser()->getId())
				Message::create(UserAccount::get(UserAccount::ID_SYSTEM_ACCOUNT)->getPerson(), $owner, 'Users changed for Property: ' . $this->getProperty()->getAddress(), str_replace('{roleName}', 'Owner', $message), Message::TYPE_EMAIL);
		}
			
		//inform all the agents
		$agents = Person::getUsersForProperty($this->getProperty(), Role::get(Role::ID_AGENT));
		foreach($agents as $agent)
		{
			if($agent->getId() !== Core::getUser()->getId())
				Message::create(UserAccount::get(UserAccount::ID_SYSTEM_ACCOUNT)->getPerson(), $agent, 'Users changed for Property: ' . $this->getProperty()->getAddress(), str_replace('{roleName}', 'Agent', $message), Message::TYPE_EMAIL);
		}
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
        DaoMap::setManyToOne('person', 'Person');
        
        parent::__loadDaoMap();
        DaoMap::commit();
    }
    /**
     * Getting the relationships for a user
     * 
     * @param Property    $property
     * @param Person      $person
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
    public static function getRelationships(Property $property = null, Person $person = null, Role $role = null, $activeOnly = true, $pageNo = null, $pageSize = DaoQuery::DEFAUTL_PAGE_SIZE, $orderBy = array(), &$stats = array())
    {
    	if(!$property instanceof Property && !$person instanceof Person)
    		throw new CoreException('At least one of the search criterial should be provided: property or user');
    	$where = array();
    	$param = array();
    	if($property instanceof Property)
    	{
    		$where[]= 'propertyId = ?';
    		$param[] = $property->getId();
    	}
    	if($person instanceof Person)
    	{
    		$where[] = 'personId = ?';
    		$param[] = $person->getId();
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
     * @param Person      $person
     * @param Role        $role
     * 
     * @return PropertyRel
     */
    public static function create(Property $property, Person $person, Role $role)
    {
    	$exsitingRels = self::getAllByCriteria('propertyId = ? and personId = ? and roleId = ?', array($property->getId(), $person->getId(), $role->getId()), true, 1, 1);
    	if(count($exsitingRels) > 0)
    		return $exsitingRels[0];
    	$msg = 'User(' . $person->getFullName() . ') is now a ' . $role->getName() . ' of Property(ID=' . $property->getSKey() . ').';
    	$rel = new PropertyRel();
    	return $rel->setProperty($property->addLog(Log::TYPE_SYS, $msg, __CLASS__ . '::' . __FUNCTION__))
    		->setPerson($person)
    		->setRole($role)
    		->save()
    		->addLog(Log::TYPE_SYS, $msg, __CLASS__ . '::' . __FUNCTION__);
    }
    /**
     * deleting the property relationships
     * 
     * @param Property    $property
     * @param Person      $person
     * @param Role        $role
     */
    public static function delete(Property $property, Person $person, Role $role = null)
    {
    	$where = 'propertyId = ? and personId = ?';
    	$params = array($property->getId(), $person->getId());
    	if($role instanceof Role)
    	{
    		$where .= ' AND roleId = ?';
    		$params[] = $role->getId();
    	}
    	self::updateByCriteria('active = 0', $where, $params);
    }
}
?>
