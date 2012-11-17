<?php
/**
 *
 * @package Xcore
 * @version $Id: ImagecategoryAdminNewForm.class.php,v 1.4 2008/09/25 15:10:54 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momonga-project/momonga>
 * @license https://github.com/momonga-project/momonga/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/modules/xcore/kernel/XCube_ActionForm.class.php";
require_once XOOPS_MODULE_PATH . "/xcore/class/Xcore_Validator.class.php";
require_once XOOPS_MODULE_PATH . "/xcore/admin/forms/ImagecategoryAdminEditForm.class.php";

class Xcore_ImagecategoryAdminNewForm extends Xcore_ImagecategoryAdminEditForm
{
	function getTokenName()
	{
		return "module.xcore.ImagecategoryAdminNewForm.TOKEN";
	}

	function prepare()
	{
		parent::prepare();
		
		//
		// Set form properties
		//
		$this->mFormProperties['imgcat_storetype'] =new XCube_StringProperty('imgcat_storetype');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['imgcat_storetype'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['imgcat_storetype']->setDependsByArray(array('required','mask'));
		$this->mFieldProperties['imgcat_storetype']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_IMGCAT_STORETYPE);
		$this->mFieldProperties['imgcat_storetype']->addMessage('mask', _MD_XCORE_ERROR_MASK, _AD_XCORE_LANG_IMGCAT_STORETYPE);
		$this->mFieldProperties['imgcat_storetype']->addVar('mask', '/^(file|db)$/');
	}
	
	function load(&$obj)
	{
		parent::load($obj);
		$this->set('imgcat_storetype', $obj->get('imgcat_storetype'));
	}

	function update(&$obj)
	{
		parent::update($obj);
		$obj->set('imgcat_storetype', $this->get('imgcat_storetype'));
	}
}

?>
