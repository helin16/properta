<?php
/**
 * The bootraptable Loader
 *
 * @package    web
 * @subpackage controls
 * @author     lhe<helin16@gmail.com>
 */
class bootstrapTable extends TClientScript
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
			$folder = $this->publishFilePath(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR);
			$clientScript->registerHeadScriptFile('bootstrap.table.js', $folder . '/bootstrap-table.min.js');
			$clientScript->registerStyleSheetFile('bootstrap.table.css', $folder . '/bootstrap-table.min.css', 'screen');
		}
	}
}