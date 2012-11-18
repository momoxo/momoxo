<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/modules/xcore/kernel/XCube_ActionForm.class.php";
require_once XOOPS_MODULE_PATH . "/xcore/class/Xcore_Validator.class.php";

class Xcore_TplfileUploadForm extends XCube_ActionForm
{
	function getTokenName()
	{
		return "module.xcore.TplfileUploadForm.TOKEN";
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['upload'] =new XCube_FileArrayProperty('upload');
	
		//
		// Set field properties
		//
	}
}

?>
