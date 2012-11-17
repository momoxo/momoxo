<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

class XcoreRender_AbstractEditAction extends XcoreRender_Action
{
	var $mObject = null;
	var $mObjectHandler = null;
	var $mActionForm = null;

	function _getId()
	{
	}

	function &_getHandler()
	{
	}

	function _setupActionForm()
	{
	}

	function _setupObject()
	{
		$id = $this->_getId();
		
		$this->mObjectHandler = $this->_getHandler();
		
		$this->mObject =& $this->mObjectHandler->get($id);
	
		if ($this->mObject == null && $this->isEnableCreate()) {
			$this->mObject =& $this->mObjectHandler->create();
		}
	}

	function isEnableCreate()
	{
		return true;
	}

	function prepare(&$controller, &$xoopsUser)
	{
		$this->_setupActionForm();
		$this->_setupObject();
	}

	function getDefaultView(&$controller, &$xoopsUser)
	{
		if ($this->mObject == null) {
			return XCORERENDER_FRAME_VIEW_ERROR;
		}
	
		$this->mActionForm->load($this->mObject);
	
		return XCORERENDER_FRAME_VIEW_INPUT;
	}

	function execute(&$controller, &$xoopsUser)
	{
		if ($this->mObject == null) {
			return XCORERENDER_FRAME_VIEW_ERROR;
		}
		
		if (xoops_getrequest('_form_control_cancel') != null) {
			return XCORERENDER_FRAME_VIEW_CANCEL;
		}
	
		$this->mActionForm->load($this->mObject);
		
		$this->mActionForm->fetch();
		$this->mActionForm->validate();
	
		if($this->mActionForm->hasError()) {
			return XCORERENDER_FRAME_VIEW_INPUT;
		}
	
		$this->mActionForm->update($this->mObject);
		
		return $this->_doExecute($this->mObject) ? XCORERENDER_FRAME_VIEW_SUCCESS
		                                         : XCORERENDER_FRAME_VIEW_ERROR;
	}

	function _doExecute()
	{
		return $this->mObjectHandler->insert($this->mObject);
	}
}

?>
