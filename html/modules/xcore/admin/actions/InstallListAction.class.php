<?php
/**
 *
 * @package Xcore
 * @version $Id: InstallListAction.class.php,v 1.4 2008/09/25 15:11:45 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momonga-project/momonga>
 * @license https://github.com/momonga-project/momonga/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

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

?>
