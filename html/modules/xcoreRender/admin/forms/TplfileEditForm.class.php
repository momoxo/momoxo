<?php
/**
 * @package xcore
 * @version $Id: TplfileEditForm.class.php,v 1.2 2007/06/07 02:23:37 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/modules/xcore/kernel/XCube_ActionForm.class.php";

/***
 * @internal
 * This class is generated by makeActionForm tool.
 */
class Xcore_TplfileEditForm extends XCube_ActionForm
{
	function getTokenName()
	{
		return "module.xcore.TplfileEditForm.TOKEN." . $this->get('tpl_id');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['tpl_id'] =new XCube_IntProperty('tpl_id');
		$this->mFormProperties['tpl_desc'] =new XCube_StringProperty('tpl_desc');
		$this->mFormProperties['tpl_source'] =new XCube_TextProperty('tpl_source');

		//
		// Set field properties
		//
		$this->mFieldProperties['tpl_id'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['tpl_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['tpl_id']->addMessage('required', _AD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_TPL_ID);

		$this->mFieldProperties['tpl_desc'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['tpl_desc']->setDependsByArray(array('maxlength'));
		$this->mFieldProperties['tpl_desc']->addMessage('maxlength', _AD_XCORE_ERROR_MAXLENGTH, _AD_XCORE_LANG_TPL_DESC, '255');
		$this->mFieldProperties['tpl_desc']->addVar('maxlength', 255);

		$this->mFieldProperties['tpl_source'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['tpl_source']->setDependsByArray(array('required'));
		$this->mFieldProperties['tpl_source']->addMessage('required', _AD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_TPL_SOURCE);
	}

	function load(&$obj)
	{
		$obj->loadSource();
		
		$this->set('tpl_id', $obj->get('tpl_id'));
		$this->set('tpl_desc', $obj->get('tpl_desc'));
		$this->set('tpl_source', $obj->Source->get('tpl_source'));
	}

	function update(&$obj)
	{
		$obj->loadSource();

		$obj->set('tpl_id', $this->get('tpl_id'));
		$obj->set('tpl_desc', $this->get('tpl_desc'));

		$obj->set('tpl_lastmodified', time());

		$obj->Source->set('tpl_source', $this->get('tpl_source'));
	}
}

?>
