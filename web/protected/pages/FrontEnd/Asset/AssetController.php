<?php
/**
 * This is the Asset Streamer
 * 
 * @package    Web
 * @subpackage Controller
 * @author     lhe<helin16@gmail.com>
 *
 */
class AssetController extends TService
{
    /**
     * (non-PHPdoc)
     * @see TService::run()
     */
    public function run()
    {
        try 
        {
            $method = '_' . ((isset($this->Request['method']) && trim($this->Request['method']) !== '') ? trim($this->Request['method']) : '');
            if(!method_exists($this, $method))
                throw new Exception('No such a method: ' . $method . '!');
            $this->$method($_REQUEST);
        }
        catch (Exception $ex)
        {
            $this->getResponse()->write($ex->getMessage());
        }
    }
    /**
     * Getting the id
     * 
     * @param array $params
     * 
     * @return mix
     */
    private function _get($params)
    {
    	if(!isset($params['id']) || ($assetId = trim($params['id'])) === '')
    		throw new Exception('Nothing to get!');
    	if(!($asset = Asset::getAsset($assetId)) instanceof Asset)
	        throw new Exception('Nothing found for: ' . $assetId);
    	$this->getResponse()->writeFile($asset->getFileName(), file_get_contents($asset->getPath()), $asset->getMimeType(), null, false);
    }
}