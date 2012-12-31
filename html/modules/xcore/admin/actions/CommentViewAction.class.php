<?php

use XCore\Database\Criteria;

class Xcore_CommentViewAction extends Xcore_Action
{
	var $mObject = null;
	
	function getDefaultView(&$controller, &$xoopsUser)
	{
		$handler =& xoops_getmodulehandler('comment');
		$this->mObject =& $handler->get(xoops_getrequest('com_id'));
		
		if ($this->mObject == null) {
			return XCORE_FRAME_VIEW_ERROR;
		}

		return XCORE_FRAME_VIEW_SUCCESS;
	}
		
	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		//
		// Lazy load
		//
		$this->mObject->loadModule();
		$this->mObject->loadUser();
		$this->mObject->loadStatus();

		$render->setTemplateName("comment_view.html");
		$render->setAttribute('object', $this->mObject);

		//
		// Load children of specified comment and assign those.
		//
		$handler =& xoops_getmodulehandler('comment');
		$criteria =new Criteria('com_pid', $this->mObject->get('com_id'));
		$children =& $handler->getObjects($criteria);

		if (count($children) > 0) {
			foreach (array_keys($children) as $key) {
				$children[$key]->loadModule();
				$children[$key]->loadUser();
			}
		}
		$render->setAttribute('children', $children);
	}
	
	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward('./index.php');
	}
}

