<?php
/**
 *
 * @package Xcore
 * @version $Id: BlockInstallEditForm.class.php,v 1.3 2008/09/25 15:11:17 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momonga-project/momonga>
 * @license https://github.com/momonga-project/momonga/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/modules/xcore/admin/forms/BlockEditForm.class.php";

class Xcore_BlockInstallEditForm extends Xcore_BlockEditForm
{
	function getTokenName()
	{
		return "module.xcore.BlockInstallEditForm.TOKEN" . $this->get('bid');
	}
	
	function update(&$obj)
	{
		parent::update($obj);
		$obj->set('visible', true);
	}
}

?>
