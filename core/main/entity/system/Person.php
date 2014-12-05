<?php
/**
 * Person Entity
 *
 * @package    Core
 * @subpackage Entity
 * @author     lhe<helin16@gmail.com>
 */
class Person extends BaseEntityAbstract
{
    /**
     * The email
     *
     * @var string
     */
    private $email;
    /**
     * The first name of the user
     * 
     * @var string
     */
    private $firstName;
    /**
     * The last name of the user
     * 
     * @var string
     */
    private $lastName;
    /**
     * Getter for firstName
     *
     * @return string
     */
    public function getFirstName() 
    {
        return $this->firstName;
    }
    /**
     * Setter for firstName
     *
     * @param string $value The firstName
     *
     * @return Person
     */
    public function setFirstName($value) 
    {
        $this->firstName = $value;
        return $this;
    }
    /**
     * Getter for lastName
     *
     * @return 
     */
    public function getLastName() 
    {
        return $this->lastName;
    }
    /**
     * Setter for lastName
     *
     * @param string $value The lastName
     *
     * @return Person
     */
    public function setLastName($value) 
    {
        $this->lastName = $value;
        return $this;
    }
    /**
     * Getter for email
     *
     * @return 
     */
    public function getEmail() 
    {
        return $this->email;
    }
    /**
     * Setter for email
     *
     * @param string $value The email
     *
     * @return Person
     */
    public function setEmail($value)
    {
        $this->email = $value;
        return $this;
    }
    /**
     * getter Person
     *
     * @return Person
     */
    public function getPerson()
    {
        $this->loadManyToOne("person");
        return $this->person;
    }
    /**
     * (non-PHPdoc)
     * @see BaseEntity::__toString()
     */
    public function __toString()
    {
        return $this->getEmail();
    }
    /**
     * Getting the full name of the user
     * @return string
     */
    public function getFullName()
    {
    	return trim(trim($this->getFirstName()) . ' ' . trim($this->getLastName()));
    }
    /**
     * (non-PHPdoc)
     * @see BaseEntityAbstract::preSave()
     */
    public function preSave()
    {
    	if(trim($this->getEmail()) === '')
    		throw new EntityException('Email can NOT be empty', 'exception_entity_person_email_empty');
    }
    /**
     * (non-PHPdoc)
     * @see BaseEntity::__loadDaoMap()
     */
    public function __loadDaoMap()
    {
        DaoMap::begin($this, 'p');
        DaoMap::setStringType('email', 'varchar', 100);
        DaoMap::setStringType('firstName', 'varchar', 50);
        DaoMap::setStringType('lastName', 'varchar', 50);
        parent::__loadDaoMap();
        
        DaoMap::createIndex('email');
        DaoMap::createIndex('firstName');
        DaoMap::createIndex('lastName');
        DaoMap::commit();
    }
    /**
     * creating a perosn
     * 
     * @param unknown $firstName
     * @param unknown $lastName
     * @param unknown $email
     * 
     * @return Person
     */
    public static function create($firstName, $lastName, $email)
    {
    	$entity = new Person();
    	return $entity->setFirstName(trim($firstName))
    		->setLastName(trim($lastName))
    		->setEmail($email)
    		->save()
    		->addLog(Log::TYPE_SYS, 'Person (' . $firstName . ' ' . $lastName . ') created now with an email address: ' . $email);
    }
    /**
     * Getting all the users for this property
     *
     * @param Property $property
     * @param Role     $role
     *
     * @return multitype:UserAccount
     */
    public static function getUsersForProperty(Property $property, Role $role = null)
    {
    	$rels = PropertyRel::getRelationships($property, null, $role);
    	return array_unique(array_map(create_function('$a', 'return $a->getPerson();'), $rels));
    }
}

?>
