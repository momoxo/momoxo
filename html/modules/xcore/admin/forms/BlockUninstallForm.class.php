<?php
/**
 *
 * @package Xcore
 * @version $Id: BlockUninstallForm.class.php,v 1.3 2008/09/25 15:11:07 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momonga-project/momonga>
 * @license https://github.com/momonga-project/momonga/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcore/admin/forms/CustomBlockDeleteForm.class.php";

class Xcore_BlockUninstallForm extends Xcore_CustomBlockDeleteForm
{
	function getTokenName()
	{
		return "module.xcore.BlockUninstallForm.TOKEN" . $this->get('bid');
	}

	function update(&$obj)
	{
		parent::update($obj);
		$obj->set('last_modified', time());
		$obj->set('visible', false);
	}
}

?>
