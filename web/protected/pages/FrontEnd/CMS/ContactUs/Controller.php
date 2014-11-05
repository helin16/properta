<?php
/**
 * This is the ContactUs page
 * 
 * @package    Web
 * @subpackage Controller
 * @author     lhe<helin16@gmail.com>
 */
class Controller extends FrontEndPageAbstract
{
    /**
     * (non-PHPdoc)
     * @see FrontEndPageAbstract::_getEndJs()
     */
    protected function _getEndJs()
    {
        $js = parent::_getEndJs();
        $js .='(function($) {
		  	"use strict";
			$(".top-head").affix({
				offset: {
					top: 100
				}
			});
        })(jQuery);';
        return $js;
    }
}