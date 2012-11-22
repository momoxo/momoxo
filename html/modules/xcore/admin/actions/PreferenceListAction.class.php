<?php

class Xcore_PreferenceListAction extends Xcore_Action
{
	var $mObjects = array();
	
	function prepare(&$controller, &$xoopsUser)
	{
	}
	
	function getDefaultView(&$controller, &$xoopsUser)
	{
		$handler =& xoops_gethandler('configcategory');
        $criteria = new CriteriaCompo();
        $criteria->addSort('confcat_id', 'ASC');
		$this->mObjects =& $handler->getObjects($criteria);
		
		return XCORE_FRAME_VIEW_INDEX;
	}
	
	function execute(&$controller, &$xoopsUser)
	{
		return $this->getDefaultView($controller, $xoopsUser);
	}

	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName("preference_list.html");
		$render->setAttribute('objects', $this->mObjects);
	}
}

