<?php

use XCore\Kernel\Root;

define('XCORE_SEARCH_RESULT_MAXHIT', 5);
define('XCORE_SEARCH_SHOWALL_MAXHIT', 20);

class Xcore_SearchResultsAction extends Xcore_Action
{
	var $mActionForm = null;
	var $mSearchResults = array();
	var $mModules = array();
	
	var $mConfig = array();
	
	function prepare(&$controller, &$xoopsUser)
	{
		$root =& $controller->mRoot;
		$root->mLanguageManager->loadPageTypeMessageCatalog('search');
		$root->mLanguageManager->loadModuleMessageCatalog('xcore');
		
		$handler =& xoops_gethandler('config');
		$this->mConfig =& $handler->getConfigsByCat(XOOPS_CONF_SEARCH);
		
		$this->_setupActionForm();
	}
	
	function _setupActionForm()
	{
		$this->mActionForm =new Xcore_SearchResultsForm($this->mConfig['keyword_min']);
		$this->mActionForm->prepare();
	}
	
	function hasPermission(&$controller, &$xoopsUser)
	{
		if ($this->mConfig['enable_search'] != 1) {
			$controller->executeRedirect(XOOPS_URL . '/', 3, _MD_XCORE_ERROR_SEARCH_NOT_ENABLED);
			return false;
		}
		return true;
	}
	
	function _getMaxHit()
	{
		return XCORE_SEARCH_RESULT_MAXHIT;
	}
	
	function getDefaultView(&$controller, &$xoopsUser)
	{
		$root =& $controller->mRoot;
		$service =& $root->mServiceManager->getService("XcoreSearch");
		
		if (is_object($service)) {
			$client =& $root->mServiceManager->createClient($service);
			$this->mModules = $client->call('getActiveModules', array());
		}
		
		$this->mActionForm->fetch();
		$this->mActionForm->validate();
		
		if ($this->mActionForm->hasError()) {
			return XCORE_FRAME_VIEW_INDEX;
		}

		//
		// TODO ErrorHandling
		//
		if (is_object($service)) {
			$this->mActionForm->update($params);
			
			$handler =& xoops_gethandler('module');
			foreach ($this->_getSelectedMids() as $mid) {
				$t_module =& $handler->get($mid);
				if (is_object($t_module)) {
					$module = array();
					
					$module['mid'] = $mid;
					$module['name'] = $t_module->get('name');
					
					$params['mid'] = $mid;
					$module['results'] = $this->_doSearch($client, $xoopsUser, $params);
					
					if (count($module['results']) > 0) {
						$module['has_more'] = (count($module['results']) >= $this->_getMaxHit()) ? true : false;
						$this->mSearchResults[] = $module;
					}
				}
			}
		}
		else {
			return XCORE_FRAME_VIEW_ERROR;
		}

		return XCORE_FRAME_VIEW_INDEX;
	}
	
	function _doSearch(&$client, &$xoopsUser, &$params)
	{
		$root =& Root::getSingleton();
		$timezone = $root->mContext->getXoopsConfig('server_TZ') * 3600;
		
		$results = $client->call('searchItems', $params);
		
		return $results;
	}
	
	function execute(&$controller, &$xoopsUser)
	{
		return $this->getDefaultView($controller, $xoopsUser);
	}
	
	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName($this->_getTemplateName());
	
		$render->setAttribute('actionForm', $this->mActionForm);
			
		$render->setAttribute('searchResults', $this->mSearchResults);
		$render->setAttribute('moduleArr', $this->mModules);

		//
		// If the request include $mids, setAttribute it. If it don't include, 
		// setAttribute $mid or $this->mModules.
		//		
		$render->setAttribute('selectedMidArr', $this->_getSelectedMids());
		$render->setAttribute('searchRuleMessage', @sprintf(_SR_KEYTOOSHORT, $this->mConfig['keyword_min']));
	}
	
	function _getTemplateName()
	{
		return "xcore_search_results.html";
	}
	
	function _getSelectedMids()
	{
		$ret = $this->mActionForm->get('mids');
		if (!count($ret)) {
			foreach ($this->mModules as $module) {
				$ret[] = $module['mid'];
			}
		}
		
		return $ret;
	}

	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward(XOOPS_URL . '/');
	}
}

