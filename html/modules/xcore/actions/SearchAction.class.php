<?php
/**
 *
 * @package Xcore
 * @version $Id: SearchAction.class.php,v 1.3 2008/09/25 15:12:07 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momonga-project/momonga>
 * @license https://github.com/momonga-project/momonga/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcore/actions/SearchResultsAction.class.php";
require_once XOOPS_MODULE_PATH . "/xcore/forms/SearchResultsForm.class.php";

class Xcore_SearchAction extends Xcore_SearchResultsAction
{
	function getDefaultView(&$controller, &$xoopsUser)
	{
		$root =& $controller->mRoot;
		$service =& $root->mServiceManager->getService("XcoreSearch");
		if (is_object($service)) {
			$client =& $root->mServiceManager->createClient($service);

			$this->mModules = $client->call('getActiveModules', array());
		}
		
		return XCORE_FRAME_VIEW_INDEX;
	}
	
	function _getSelectedMids()
	{
		$ret = array();
		foreach(array_keys($this->mModules) as $key) {
			$ret[] = $this->mModules[$key]['mid'];
		}
		
		return $ret;
	}
	
	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName("xcore_search_form.html");
	
		$render->setAttribute('actionForm', $this->mActionForm);
			
		$render->setAttribute('moduleArr', $this->mModules);

		//
		// If the request include $mids, setAttribute it. If it don't include, 
		// setAttribute $mid or $this->mModules.
		//		
		$render->setAttribute('selectedMidArr', $this->_getSelectedMids());
		$render->setAttribute('searchRuleMessage', @sprintf(_SR_KEYTOOSHORT, $this->mConfig['keyword_min']));
	}
}

?>
