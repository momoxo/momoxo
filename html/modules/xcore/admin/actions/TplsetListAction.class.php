<?php

use XCore\Database\CriteriaCompo;
use XCore\Database\Criteria;

class Xcore_TplsetListAction extends Xcore_AbstractListAction
{
	var $mActionForm = null;
	var $mActiveTemplateSet = null;
	
	function prepare(&$controller, &$xoopsUser, $moduleConfig)
	{
		Xcore_AbstractListAction::prepare($controller, $xoopsUser, $moduleConfig);
		$this->mActionForm =new Xcore_TplsetSelectForm();
		$this->mActionForm->prepare();
	}
	
	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('tplset');
		return $handler;
	}

	function &_getFilterForm()
	{
		$filter =new Xcore_TplsetFilterForm($this->_getPageNavi(), $this->_getHandler());
		return $filter;
	}
	
	function _getBaseUrl()
	{
		return "./index.php?action=TplsetList";
	}
	
	function execute(&$controller, &$xoopsUser)
	{
		$this->mActionForm->fetch();
		$this->mActionForm->validate();
		if (!$this->mActionForm->hasError()) {
			$configHandler =& xoops_gethandler('config');

			$criteria =new CriteriaCompo();
			$criteria->add(new Criteria('conf_name', 'template_set'));
			$criteria->add(new Criteria('conf_catid', XOOPS_CONF));
			
			$configs =& $configHandler->getConfigs($criteria);
			if (count($configs) > 0) {
				$configs[0]->set('conf_value', $this->mActionForm->get('tplset_name'));
				$configHandler->insertConfig($configs[0]);
				$this->mActiveTemplateSet = $this->mActionForm->get('tplset_name');
			}
		}

		return $this->getDefaultView($controller, $xoopsUser);
	}

	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
		//
		// Load the list of module templates.
		//
		foreach (array_keys($this->mObjects) as $key) {
			$this->mObjects[$key]->loadModuletpl();
		}

		if ($this->mActiveTemplateSet == null) {
			$this->mActiveTemplateSet = $controller->mRoot->mContext->getXoopsConfig('template_set');
		}

		$render->setTemplateName("tplset_list.html");
		$render->setAttribute('objects', $this->mObjects);
		$render->setAttribute('pageNavi', $this->mFilter->mNavi);
		$render->setAttribute('activeTemplateSet', $this->mActiveTemplateSet);
		$render->setAttribute('actionForm', $this->mActionForm);
		
		//
		// Assign recent modified tplfile objects
		//
		$handler =& xoops_getmodulehandler('tplfile');
		$recentObjects =& $handler->getRecentModifyFile();
		
		$render->setAttribute('recentObjects', $recentObjects);
	}
}

