<?php
// override Xcore_ActionFrame::_createAction()
// if XCL supports delegate "Module(Install|Update|Uninstall).Success" can remove this file
// and can remove a file xupdate/admin/class/Xcore_ModuleActions.class.php

use XCore\Kernel\ActionFilter;

class Xupdate_ModuleActionOverride extends ActionFilter
{
    /**
     * preBlockFilter
     *
     * @param   void
     *
     * @return  void
    **/
    public function preBlockFilter()
    {
        $this->mRoot->mDelegateManager->add('Xcore_ActionFrame.CreateAction', array(&$this, '_createAction'), XCUBE_DELEGATE_PRIORITY_FIRST);
    }

	// override Xcore_ActionFrame::_createAction()
	// if XCL supports delegate "Module(Install|Update|Uninstall).Success" can remove this function
	public function _createAction(&$actionFrame)
	{
		if (is_object($actionFrame->mAction)) {
			return;
		}
	
		$overrideActionNames = array('ModuleList', 'ModuleInstall', 'ModuleUpdate', 'ModuleUninstall');
		$actionName = ucfirst($actionFrame->mActionName);

		if ( in_array($actionName, $overrideActionNames) === false ) {
    		// exec default _createAction
			return;
		}

		require_once XOOPS_XCORE_PATH . '/admin/actions/' . $actionName . 'Action.class.php';
		require_once XOOPS_TRUST_PATH . '/modules/xupdate/admin/class/Xcore_ModuleActions.class.php';

		$className = 'Xupdate_'.$actionName.'Action';
		
		if (class_exists($className)) {
			$actionFrame->mAction =new $className($actionFrame->mAdminFlag);
		}
	}
}