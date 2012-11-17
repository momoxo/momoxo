<?php
/**
 *
 * @package Xcore
 * @version $Id: BlockInstallFilterForm.class.php,v 1.3 2008/09/25 15:11:19 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momonga-project/momonga>
 * @license https://github.com/momonga-project/momonga/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcore/admin/forms/BlockFilterForm.class.php";

class Xcore_BlockInstallFilterForm extends Xcore_BlockFilterForm
{
	function _getVisible()
	{
		return 0;
	}
}

?>
