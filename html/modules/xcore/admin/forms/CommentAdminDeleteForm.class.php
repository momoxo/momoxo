<?php
/**
 *
 * @package Xcore
 * @version $Id: CommentAdminDeleteForm.class.php,v 1.4 2008/09/25 15:10:35 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momonga-project/momonga>
 * @license https://github.com/momonga-project/momonga/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";

/***
 * @internal
 */
class Xcore_CommentAdminDeleteForm extends XCube_ActionForm
{
	function getTokenName()
	{
		return "module.xcore.XoopscommentsAdminDeleteForm.TOKEN" . $this->get('com_id');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['com_id'] =new XCube_IntProperty('com_id');
		$this->mFormProperties['delete_mode'] =new XCube_StringProperty('delete_mode');

		//
		// Set field properties
		//
		$this->mFieldProperties['com_id'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['com_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['com_id']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_XCORE_LANG_COM_ID);
	}

	function load(&$obj)
	{
		$this->setVar('com_id', $obj->get('com_id'));
	}

	function update(&$obj)
	{
		$obj->setVar('com_id', $this->get('com_id'));
	}
}

?>
