<?php
/**
 *
 * @package Xcore
 * @version $Id: SearchShowallAction.class.php,v 1.3 2008/09/25 15:12:10 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momonga-project/momonga>
 * @license https://github.com/momonga-project/momonga/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcore/actions/SearchResultsAction.class.php";
require_once XOOPS_MODULE_PATH . "/xcore/forms/SearchShowallForm.class.php";

class Xcore_SearchShowallAction extends Xcore_SearchResultsAction
{
	function _setupActionForm()
	{
		$this->mActionForm =new Xcore_SearchShowallForm($this->mConfig['keyword_min']);
		$this->mActionForm->prepare();
	}
	
	function _getTemplateName()
	{
		return "xcore_search_showall.html";
	}
	
	function _getSelectedMids()
	{
		$ret = array();
		$ret[] = $this->mActionForm->get('mid');
		
		return $ret;
	}
	
	function _getMaxHit()
	{
		return XCORE_SEARCH_SHOWALL_MAXHIT;
	}
	
	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
		parent::executeViewIndex($controller, $xoopsUser, $render);
		
		$prevStart = $this->mActionForm->get('start') - XCORE_SEARCH_SHOWALL_MAXHIT;
		if ($prevStart < 0) {
			$prevStart = 0;
		}
		
		$render->setAttribute('prevStart', $prevStart);
		$render->setAttribute('nextStart', $this->mActionForm->get('start') + XCORE_SEARCH_SHOWALL_MAXHIT);
	}
}

?>
