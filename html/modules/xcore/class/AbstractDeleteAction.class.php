<?php
/**
 *
 * @package Xcore
 * @version $Id: AbstractDeleteAction.class.php,v 1.3 2008/09/25 15:11:26 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momonga-project/momonga>
 * @license https://github.com/momonga-project/momonga/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcore/class/AbstractEditAction.class.php";

class Xcore_AbstractDeleteAction extends Xcore_AbstractEditAction
{
	function isEnableCreate()
	{
		return false;
	}

	function _doExecute()
	{
		return $this->mObjectHandler->delete($this->mObject);
	}
}

?>