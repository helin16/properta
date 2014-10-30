<?php
/**
 * UserAccount Entity
 *
 * @package    Core
 * @subpackage Entity
 * @author     lhe<helin16@gmail.com>
 */
class UserAccount extends BaseEntityAbstract
{
    /**
     * The id of the GUEST account
     * 
     * @var int
     */
    const ID_GUEST_ACCOUNT = 1;
    /**
     * The id of the system account
     * 
     * @var int
     */
    const ID_SYSTEM_ACCOUNT = 42;
    /**
     * The email
     *
     * @var string
     */
    private $email;
    /**
     * The password
     *
     * @var string
     */
    private $password;
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
     * @return UserAccount
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
     * @return UserAccount
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
     * @return UserAccount
     */
    public function setEmail($value)
    {
        $this->email = $value;
        return $this;
    }
    /**
     * getter Password
     *
     * @return String
     */
    public function getPassword()
    {
        return $this->password;
    }
    /**
     * Setter Password
     *
     * @param string $Password The password
     *
     * @return UserAccount
     */
    public function setPassword($Password)
    {
        $this->password = $Password;
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
     * Setter Person
     *
     * @param Person $Person The person that this useraccount belongs to
     *
     * @return UserAccount
     */
    public function setPerson(Person $Person)
    {
        $this->person = $Person;
        return $this;
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
     * (non-PHPdoc)
     * @see BaseEntityAbstract::getJson()
     */
    public function getJson($extra = '', $reset = false)
    {
    	$array = array();
    	if(!$this->isJsonLoaded($reset))
    	{
    		$array['person'] = $this->getPerson()->getJson();
    	}
    	return parent::getJson($array, $reset);
    }
    /**
     * (non-PHPdoc)
     * @see BaseEntityAbstract::preSave()
     */
    public function preSave()
    {
    	if(trim($this->getEmail()) === '')
    		throw new EntityException('Email can NOT be empty', 'exception_entity_useraccount_email_empty');
    	if(self::getUserByUsername($this->getEmail()) instanceof UserAccount)
    		throw new EntityException(array('email' => $this->getEmail()),  'exception_entity_useraccount_email_exsits');
    }
    /**
     * (non-PHPdoc)
     * @see BaseEntity::__loadDaoMap()
     */
    public function __loadDaoMap()
    {
        DaoMap::begin($this, 'ua');
        DaoMap::setStringType('email', 'varchar', 100);
        DaoMap::setStringType('password', 'varchar', 40);
        DaoMap::setStringType('firstName', 'varchar', 50);
        DaoMap::setStringType('lastName', 'varchar', 50);
        parent::__loadDaoMap();
        
        DaoMap::createUniqueIndex('email');
        DaoMap::createIndex('password');
        DaoMap::createIndex('firstName');
        DaoMap::createIndex('lastName');
        DaoMap::commit();
    }
    /**
     * Getting UserAccount
     *
     * @param string  $email    The email string
     * @param string  $password The password string
     *
     * @throws AuthenticationException
     * @throws Exception
     * @return Ambigous <BaseEntityAbstract>|NULL
     */
    public static function getUserByEmailAndPassword($email, $password, $noHashPass = false)
    {
    	$query = self::getQuery();
    	$userAccounts = self::getAllByCriteria("`email` = :email AND `Password` = :password", array('email' => $email, 'password' => ($noHashPass === true ? $password : sha1($password))), false, 1, 1);
    	if(count($userAccounts) > 1)
    		return $userAccounts[0];
    	return null;
    }
    /**
     * Getting UserAccount by username
     *
     * @param string $email The email string
     *
     * @throws AuthenticationException
     * @throws Exception
     * @return Ambigous <BaseEntityAbstract>|NULL
     */
    public static function getUserByUsername($email)
    {
    	$query = self::getQuery();
    	$userAccounts = self::getAllByCriteria("`email` = :email", array('email' => $email), false, 1, 1);
    	if(count($userAccounts) > 0)
    		return $userAccounts[0];
    	else
    		return null;
    }
    /**
     * Creating a new useraccount
     *
     * @param string $email
     * @param string $password
     * @param Role   $role
     *
     * @return UserAccount
     */
    public static function createUser($email, $password)
    {
    	$userAccount = new UserAccount();
    	return $userAccount->setUserName($username)
    		->setPassword($password)
    		->save();
    }
    /**
     * Updating an useraccount
     *
     * @param UserAccount $userAccount
     * @param string      $username
     * @param string      $password
     *
     * @return Ambigous <BaseEntity, BaseEntityAbstract>
     */
    public static function updateUser(UserAccount &$userAccount, $username, $password)
    {
    	return $userAccount->setUserName($username)
    		->setPassword($password)
    		->save();
    }
}

?>
