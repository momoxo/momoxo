<?php
/**
 *
 * @package Xcore
 * @version $Id: PreferenceListAction.class.php,v 1.3 2008/09/25 15:11:50 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momonga-project/momonga>
 * @license https://github.com/momonga-project/momonga/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcore/admin/forms/PreferenceEditForm.class.php";

class Xcore_PreferenceListAction extends Xcore_Action
{
	var $mObjects = array();
	
	function prepare(&$controller, &$xoopsUser)
	{
	}
	
	function getDefaultView(&$controller, &$xoopsUser)
	{
		$handler =& xoops_gethandler('configcategory');
		$this->mObjects =& $handler->getObjects();
		
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

?>
