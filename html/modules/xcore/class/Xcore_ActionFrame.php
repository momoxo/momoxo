<?php

use XCore\Kernel\Root;
use XCore\Kernel\Ref;
use XCore\Kernel\Delegate;

class Xcore_ActionFrame
{
	var $mActionName = null;
	var $mAction = null;
	var $mAdminFlag = null;

	/**
	 * Mode. The rule refers this property to load a file and create an
	 * instance in execute().
	 * 
	 * @var string
	 */	
	var $mMode = null;

	/**
	 * @var Delegate
	 */
	var $mCreateAction = null;
	
	function Xcore_ActionFrame($admin)
	{
		$this->mAdminFlag = $admin;
		$this->mCreateAction =new Delegate();
		$this->mCreateAction->register('Xcore_ActionFrame.CreateAction');
		$this->mCreateAction->add(array(&$this, '_createAction'));
	}

	function setActionName($name)
	{
		$this->mActionName = $name;
		
		//
		// Temp FIXME!
		//
		$root = Root::getSingleton();
		$root->mContext->setAttribute('actionName', $name);
		$root->mContext->mModule->setAttribute('actionName', $name);
	}
	
	/**
	 * Set mode.
	 * 
	 * @param string $mode   Use constants (XCORE_FRAME_MODE_MISC and more...)
	 */
	function setMode($mode)
	{
		$this->mMode = $mode;
	}

	function _createAction(&$actionFrame)
	{
		if (is_object($actionFrame->mAction)) {
			return;
		}
		
		//
		// Create action object by mActionName
		//
		$className = "Xcore_" . ucfirst($actionFrame->mActionName) . "Action";
		$fileName = ucfirst($actionFrame->mActionName) . "Action";
		if ($actionFrame->mAdminFlag) {
			$fileName = XOOPS_MODULE_PATH . "/xcore/admin/actions/${fileName}.class.php";
		}
		else {
			$fileName = XOOPS_MODULE_PATH . "/xcore/actions/${fileName}.class.php";
		}
	
		if (!file_exists($fileName)) {
			throw new RuntimeException();
		}
	
		require_once $fileName;
	
		if (class_exists($className)) {
			$actionFrame->mAction =new $className($actionFrame->mAdminFlag);
		}
	}
	
	function execute(&$controller)
	{
		if (strlen($this->mActionName) > 0 && !preg_match("/^\w+$/", $this->mActionName)) {
			throw new RuntimeException();
		}

		//
		// Actions of the public side in this module are hook type. So it's
		// necessary to load catalog here.
		//		
		if (!$this->mAdminFlag) {
			$controller->mRoot->mLanguageManager->loadModuleMessageCatalog('xcore');
		}
		
		//
		// Add mode.
		//
		$this->setActionName($this->mMode . $this->mActionName);
	
		//
		// Create action object by mActionName
		//
		$this->mCreateAction->call(new Ref($this));
	
		if (!(is_object($this->mAction) && $this->mAction instanceof Xcore_Action)) {
			throw new RuntimeException();
		}
		
		if ($this->mAction->prepare($controller, $controller->mRoot->mContext->mXoopsUser) === false) {
			throw new RuntimeException();
		}
	
		if (!$this->mAction->hasPermission($controller, $controller->mRoot->mContext->mXoopsUser)) {
			if ($this->mAdminFlag) {
				$controller->executeForward(XOOPS_URL . "/admin.php");
			}
			else {
				$controller->executeForward(XOOPS_URL);
			}
		}
	
		if (xoops_getenv("REQUEST_METHOD") == "POST") {
			$viewStatus = $this->mAction->execute($controller, $controller->mRoot->mContext->mXoopsUser);
		}
		else {
			$viewStatus = $this->mAction->getDefaultView($controller, $controller->mRoot->mContext->mXoopsUser);
		}
	
		switch($viewStatus) {
			case XCORE_FRAME_VIEW_SUCCESS:
				$this->mAction->executeViewSuccess($controller, $controller->mRoot->mContext->mXoopsUser, $controller->mRoot->mContext->mModule->getRenderTarget());
				break;
		
			case XCORE_FRAME_VIEW_ERROR:
				$this->mAction->executeViewError($controller, $controller->mRoot->mContext->mXoopsUser, $controller->mRoot->mContext->mModule->getRenderTarget());
				break;
		
			case XCORE_FRAME_VIEW_INDEX:
				$this->mAction->executeViewIndex($controller, $controller->mRoot->mContext->mXoopsUser, $controller->mRoot->mContext->mModule->getRenderTarget());
				break;
		
			case XCORE_FRAME_VIEW_INPUT:
				$this->mAction->executeViewInput($controller, $controller->mRoot->mContext->mXoopsUser, $controller->mRoot->mContext->mModule->getRenderTarget());
				break;

			case XCORE_FRAME_VIEW_PREVIEW:
				$this->mAction->executeViewPreview($controller, $controller->mRoot->mContext->mXoopsUser, $controller->mRoot->mContext->mModule->getRenderTarget());
				break;

			case XCORE_FRAME_VIEW_CANCEL:
				$this->mAction->executeViewCancel($controller, $controller->mRoot->mContext->mXoopsUser, $controller->mRoot->mContext->mModule->getRenderTarget());
				break;
		}
	}
}
