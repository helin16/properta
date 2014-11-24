<?php
/**
 * The jQuery js loader
 *
 * @package    web
 * @subpackage controls
 * @author     lhe<helin16@gmail.com>
 */
class jQuery extends TClientScript
{
	/**
	 * (non-PHPdoc)
	 * @see TControl::onLoad()
	 */
	public function onLoad($param)
	{
		$clientScript = $this->getPage()->getClientScript();
		if(!$this->getPage()->IsPostBack || !$this->getPage()->IsCallback)
		{
			$clientScript->registerHeadScriptFile('jQuery.js', '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js');
			$clientScript->registerBeginScript('jquery.noConflict', 'jQuery.noConflict();');
		}
	}
}