<?php

class Xcore_IndexRedirector extends XCube_ActionFilter
{
	function preBlockFilter()
	{
		$this->mController->mRoot->mDelegateManager->add("Xcorepage.Top.Access", array(&$this, "redirect"));
	}

	function redirect()
	{
		$startPage = $this->mRoot->mContext->getXoopsConfig('startpage');
		if ($startPage != null && $startPage != "--") {
			$handler =& xoops_gethandler('module');
			$module =& $handler->get($startPage);
			if (is_object($module) && $module->get('isactive')) {
				$this->mController->executeForward(XOOPS_URL . '/modules/' . $module->getShow('dirname') . '/');
			}
		}
	}
}
