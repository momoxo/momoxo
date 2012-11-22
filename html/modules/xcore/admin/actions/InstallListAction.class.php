<?php

/***
 * @public
 * @internal
 * List up non-installation modules.
 */
class Xcore_InstallListAction extends Xcore_Action
{
	var $mModuleObjects = null;
	
	function getDefaultView(&$controller, &$xoopsUser)
	{
		$handler =& xoops_getmodulehandler('non_installation_module');

		$this->mModuleObjects =& $handler->getObjects();
		
		return XCORE_FRAME_VIEW_INDEX;
	}
	
	function executeViewIndex(&$controller, &$xoopsUser, &$renderer)
	{
		$renderer->setTemplateName("install_list.html");
		$renderer->setAttribute('moduleObjects', $this->mModuleObjects);
	}
}

