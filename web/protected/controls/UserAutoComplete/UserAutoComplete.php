<?php
class UserAutoComplete extends TTemplateControl
{
	/**
	 * (non-PHPdoc)
	 * @see TPage::render()
	 */
	public function onLoad($param)
	{
	    parent::onLoad($param);
	    $clientScript = $this->getPage()->getCLientScript();
	    
	    $folder = $this->publishFilePath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '3rdParty' . DIRECTORY_SEPARATOR);
	    // Add jQuery library
	    // Add mousewheel plugin (this is optional)
	    $clientScript->registerHeadScriptFile('jquery.mockjax', $folder . '/mockjs.min.js');
	    $clientScript->registerHeadScriptFile('jquery.autocomplete', $folder . '/autocomplete.min.js');
	    
        $cScripts = FrontEndPageAbstract::getLastestJS(get_class($this));
	    if (isset($cScripts['js']) && ($lastestJs = trim($cScripts['js'])) !== '')
	        $clientScript->registerScriptFile(get_class($this) . 'Js', $this->publishAsset($lastestJs));
	    if (isset($cScripts['css']) && ($lastestCss = trim($cScripts['css'])) !== '')
	        $clientScript->registerStyleSheetFile(get_class($this) . 'Css', $this->publishAsset($lastestCss));
	    
	    $js = "pageJs.setCallbackId('searchPerson', '" . $this->searchPersonBtn->getUniqueID() . "');";
	    $clientScript->registerEndScript('UserAutoCompleteJs', $js);
	}
	/**
	 * Searching Person
	 * 
	 * @param unknown $sender
	 * @param unknown $param
	 * 
	 * @return UserAutoComplete
	 */
	public function searchPerson($sender, $param)
	{
		$results = $errors = array();
		try {
			$stats = $items = array();
			$people = Person::getAllByCriteria('email like :searchTxt or firstName like :searchTxt or lastName like :searchTxt', array('searchTxt' => '%' . trim($param->CallbackParameter->searchText) . '%' ));
			foreach($people as $person )
			{
				$items[] = $person->getJson();
			}
			$results['items'] = $items;
			
		} catch (Exception $ex) {
			$errors[] = $ex->getMessage();
		}
		die(StringUtilsAbstract::getJson($results, $errors));
	}
}