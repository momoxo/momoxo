<?php
/**
 *
 * @package Xcore
 * @version $Id: ImagecategoryAdminDeleteForm.class.php,v 1.3 2008/09/25 15:11:09 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momonga-project/momonga>
 * @license https://github.com/momonga-project/momonga/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/modules/xcore/kernel/XCube_ActionForm.class.php";
require_once XOOPS_MODULE_PATH . "/xcore/class/Xcore_Validator.class.php";

class Xcore_ImagecategoryAdminDeleteForm extends XCube_ActionForm
{
	function getTokenName()
	{
		return "module.xcore.ImagecategoryAdminDeleteForm.TOKEN" . $this->get('imgcat_id');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['imgcat_id'] =new XCube_IntProperty('imgcat_id');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['imgcat_id'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['imgcat_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['imgcat_id']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_IMGCAT_ID);
	}

	function load(&$obj)
	{
		$this->set('imgcat_id', $obj->get('imgcat_id'));
	}

	function update(&$obj)
	{
		$obj->set('imgcat_id', $this->get('imgcat_id'));
	}
}

?>
