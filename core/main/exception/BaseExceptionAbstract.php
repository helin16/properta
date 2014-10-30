<?php
/**
 * The BaseExceptionAbstract
 * 
 * @package    Core
 * @subpackage Exception
 * @author     lhe<helin16@gmail.com>
 */
abstract class BaseExceptionAbstract extends Exception
{
	public function __construct($msg = null, $code = null, $previous = null)
	{
		if(is_array($msg))
		{
			//get code from the language pack
			//@TODO: need to do something here!!!
			 $this->msg = $code;
		}
	}
}

?>