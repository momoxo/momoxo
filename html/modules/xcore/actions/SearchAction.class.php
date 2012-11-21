<?php

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
