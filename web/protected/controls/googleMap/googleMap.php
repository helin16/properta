<?php
/**
 * The google map js loader
 *
 * @package    web
 * @subpackage controls
 * @author     lhe<helin16@gmail.com>
 */
class googleMap extends TClientScript
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
			$clientScript->registerHeadScriptFile('googleMap.api', '//maps.googleapis.com/maps/api/js?v=3.exp&libraries=places');
		}
	}
}