<?php
/**
 * Confirm entity class
 *
 * @package Core
 * @subpackage Entity
 */
abstract class ConfirmEntityAbstract extends BaseEntityAbstract
{
	/**
	 * The comfirmation for this entity
	 * 
	 * @var Confirmation
	 */
	protected $confirmation = null;
	/**
	 * Getter for confirmation
	 *
	 * @return Confirmation
	 */
	public function getConfirmation() 
	{
		$this->loadManyToOne('confirmation');
	    return $this->confirmation;
	}
	/**
	 * Setter for confirmation
	 *
	 * @param Confirmation $value The confirmation
	 *
	 * @return ConfirmEntityAbstract
	 */
	public function setConfirmation($value = null) 
	{
	    $this->confirmation = $value;
	    return $this;
	}
	/**
	 * mark an entity to be confimed
	 * 
	 * @param string $comments The comments to go to the confirmation
	 * 
	 * @throws EntityException
	 * @return Confirmation
	 */
	public function needToConfirm($comments = '')
	{
		if(!trim($this->getId()) === '')
			throw new EntityException('Entity needs to be saved before calling:' . __CLASS__ . '::' . __FILE__ . '().');
		return Confirmation::create($this, Confirmation::TYPE_SYS, $comments);
	}
	/**
	 * confirming a entity
	 * 
	 * @return ConfirmEntityAbstract
	 */
	public function confirm()
	{
		if(!$this->getConfirmation() instanceof Confirmation)
			throw new EntityException('Nothing to confirm for ' . get_class($this) . '(ID=' . $this->getId() . ').');
		return $this->getConfirmation()->confirm();
	}
	/**
	 * (non-PHPdoc)
	 * @see BaseEntity::__loadDaoMap()
	 */
	public function __loadDaoMap()
	{
		DaoMap::setManyToOne('confirmation', 'Confirmation', 'comf', true);
		parent::__loadDaoMap();
	}
}

?>
