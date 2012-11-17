<?php
/**
 *
 * @package Xcore
 * @version $Id: AbstractListAction.class.php,v 1.3 2008/09/25 15:11:30 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momonga-project/momonga>
 * @license https://github.com/momonga-project/momonga/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/modules/xcore/kernel/XCube_PageNavigator.class.php";

class Xcore_AbstractListAction extends Xcore_Action
{
	var $mObjects = array();
	
	var $mFilter = null;

	function &_getHandler()
	{
	}

	function &_getFilterForm()
	{
	}

	function _getBaseUrl()
	{
	}
	
	function &_getPageNavi()
	{
		$navi =new XCube_PageNavigator($this->_getBaseUrl(), XCUBE_PAGENAVI_START);
		return $navi;
	}

	function getDefaultView(&$controller, &$xoopsUser)
	{
		$this->mFilter =& $this->_getFilterForm();
		$this->mFilter->fetch();
		
		$handler =& $this->_getHandler();
		$this->mObjects =& $handler->getObjects($this->mFilter->getCriteria());
		
		return XCORE_FRAME_VIEW_INDEX;
	}
}

?>
