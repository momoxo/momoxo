<?php
/**
 * @package xcore
 * @version $Id: TplsetSelectForm.class.php,v 1.2 2007/06/07 02:57:21 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/modules/xcore/kernel/XCube_ActionForm.class.php";

class Xcore_TplsetSelectForm extends XCube_ActionForm
{
	function getTokenName()
	{
		return "module.xcore.TemplatesetSelectForm.TOKEN";
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['tplset_name'] =new XCube_StringProperty('tplset_name');
	}

	function validateTplset_name()
	{
		$handler =& xoops_getmodulehandler('tplset');
		if ($handler->getCount(new Criteria('tplset_name', $this->get('tplset_name'))) == 0) {
			$this->addErrorMessage(_AD_XCORE_ERROR_TPLSET_NO_EXIST);
		}
	}
}

?>
