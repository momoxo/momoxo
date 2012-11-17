<?php
/**
 * @package xcoreRender
 * @version $Id: TplfileCloneForm.class.php,v 1.1 2007/05/15 02:34:40 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcoreRender/admin/forms/TplfileEditForm.class.php";
require_once XOOPS_MODULE_PATH . "/xcore/class/Xcore_Validator.class.php";

class XcoreRender_TplfileCloneForm extends XcoreRender_TplfileEditForm
{
	function getTokenName()
	{
		return "module.xcoreRender.TplfileCloneForm.TOKEN";
	}

	function prepare()
	{
		parent::prepare();
		
		//
		// Set form properties
		//
		$this->mFormProperties['tpl_tplset'] =new XCube_StringProperty('tpl_tplset');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['tpl_tplset'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['tpl_tplset']->setDependsByArray(array('required'));
		$this->mFieldProperties['tpl_tplset']->addMessage('required', _AD_XCORERENDER_ERROR_REQUIRED, _AD_XCORERENDER_LANG_TPL_TPLSET);
	}
	
	function validateTpl_tplset()
	{
		$tplset = $this->get('tpl_tplset');

		$handler =& xoops_getmodulehandler('tplset', 'xcoreRender');
		$criteria =new Criteria('tplset_name', $this->get('tpl_tplset'));
		$objs =& $handler->getObjects($criteria);
		
		if (count($objs) == 0) {
			$this->addErrorMessage(_AD_XCORERENDER_ERROR_TPLSET_WRONG);
		}
	}
	
	function load(&$obj)
	{
		parent::load($obj);
		$this->set('tpl_tplset', $obj->get('tpl_tplset'));
	}

	function update(&$obj)
	{
		$obj->loadSource();

		$obj->set('tpl_desc', $this->get('tpl_desc'));
		$obj->set('tpl_lastmodified', time());

		$obj->Source->set('tpl_source', $this->get('tpl_source'));
	}
}

?>