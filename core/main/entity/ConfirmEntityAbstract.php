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
	 * B
	 * @var unknown
	 */
	private $confirmedLog = false;
	/**
	 * Getter for isConfirmed
	 *
	 * @return bool
	 */
	public function getIsConfirmed() 
	{
	    return $this->isConfirmed;
	}
	/**
	 * Setter for isConfirmed
	 *
	 * @param bool $value The isConfirmed
	 *
	 * @return ConfirmEntityAbstract
	 */
	public function setIsConfirmed($value) 
	{
	    $this->isConfirmed = $value;
	    return $this;
	}
}

?>
