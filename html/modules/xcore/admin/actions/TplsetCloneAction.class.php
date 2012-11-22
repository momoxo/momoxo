<?php

class Xcore_TplsetCloneAction extends Xcore_TplsetEditAction
{
	var $mCloneObject = null;
	
	function _setupObject()
	{
		parent::_setupObject();
		$this->mCloneObject =& $this->mObjectHandler->create();
	}
	
	function _setupActionForm()
	{
		$this->mActionForm =new Xcore_TplsetCloneForm();
		$this->mActionForm->prepare();
	}

	function isAllowDefault()
	{
		return true;
	}

	function execute(&$controller, &$xoopsUser)
	{
		if ($this->mObject == null) {
			return XCORE_FRAME_VIEW_ERROR;
		}

		if (xoops_getrequest('_form_control_cancel') != null) {
			return XCORE_FRAME_VIEW_CANCEL;
		}

		//
		// If image is no, the data has to continue to keep his value.
		//
		$this->mActionForm->load($this->mCloneObject);

		$this->mActionForm->fetch();
		$this->mActionForm->validate();

		if($this->mActionForm->hasError()) {
			return XCORE_FRAME_VIEW_INPUT;
		}
			
		$this->mActionForm->update($this->mCloneObject);
		
		return $this->mObjectHandler->insertClone($this->mObject, $this->mCloneObject) ? XCORE_FRAME_VIEW_SUCCESS
		                                                     : XCORE_FRAME_VIEW_ERROR;
	}
	
	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName("tplset_clone.html");
		$render->setAttribute('actionForm', $this->mActionForm);
		$render->setAttribute('object', $this->mObject);
	}

	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward("./index.php?action=TplsetList");
	}

	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeRedirect("./index.php?action=TplsetList", 1, _AD_XCORE_ERROR_DBUPDATE_FAILED);
	}

	function executeViewCancel(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward("./index.php?action=TplsetList");
	}
}

