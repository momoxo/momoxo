<?php

use XCore\Kernel\Root;
use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;
use XCore\Property\IntArrayProperty;
use XCore\Property\IntProperty;
use XCore\Property\StringProperty;

class Xcore_ModuleEditForm extends ActionForm
{
	function getTokenName()
	{
		return "module.xcore.ModuleEditForm.TOKEN" . $this->get('mid');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['mid'] =new IntProperty('mid');
		$this->mFormProperties['name'] =new StringProperty('name');
		$this->mFormProperties['weight'] =new IntProperty('weight');
		$this->mFormProperties['read_groupid'] =new IntArrayProperty('read_groupid');
		$this->mFormProperties['admin_groupid'] =new IntArrayProperty('admin_groupid');
		$this->mFormProperties['module_cache'] =new StringProperty('module_cache');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['mid'] =new FieldProperty($this);
		$this->mFieldProperties['mid']->setDependsByArray(array('required'));
		$this->mFieldProperties['mid']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_MOD_MID);
	
		$this->mFieldProperties['name'] =new FieldProperty($this);
		$this->mFieldProperties['name']->setDependsByArray(array('required','maxlength'));
		$this->mFieldProperties['name']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_NAME, '255');
		$this->mFieldProperties['name']->addMessage('maxlength', _MD_XCORE_ERROR_MAXLENGTH, _AD_XCORE_LANG_NAME, '255');
		$this->mFieldProperties['name']->addVar('maxlength', '255');
	
		$this->mFieldProperties['weight'] =new FieldProperty($this);
		$this->mFieldProperties['weight']->setDependsByArray(array('required', 'intRange'));
		$this->mFieldProperties['weight']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_WEIGHT);
		$this->mFieldProperties['weight']->addMessage('intRange', _AD_XCORE_ERROR_INTRANGE, _AD_XCORE_LANG_WEIGHT);
		$this->mFieldProperties['weight']->addVar('min', '0');
		$this->mFieldProperties['weight']->addVar('max', '255');
	
		$this->mFieldProperties['read_groupid'] =new FieldProperty($this);
		$this->mFieldProperties['read_groupid']->setDependsByArray(array('objectExist'));
		$this->mFieldProperties['read_groupid']->addMessage('objectExist', _AD_XCORE_ERROR_OBJECTEXIST, _AD_XCORE_LANG_GROUPID);
		$this->mFieldProperties['read_groupid']->addVar('handler', 'group');

		$this->mFieldProperties['admin_groupid'] =new FieldProperty($this);
		$this->mFieldProperties['admin_groupid']->setDependsByArray(array('objectExist'));
		$this->mFieldProperties['admin_groupid']->addMessage('objectExist', _AD_XCORE_ERROR_OBJECTEXIST, _AD_XCORE_LANG_GROUPID);
		$this->mFieldProperties['admin_groupid']->addVar('handler', 'group');

		$this->mFieldProperties['module_cache'] =new FieldProperty($this);
		$this->mFieldProperties['module_cache']->setDependsByArray(array('required', 'objectExist'));
		$this->mFieldProperties['module_cache']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_AM_MODCACHE);
		$this->mFieldProperties['module_cache']->addMessage('objectExist', _AD_XCORE_ERROR_OBJECTEXIST, _MD_AM_MODCACHE);
		$this->mFieldProperties['module_cache']->addVar('handler', 'cachetime');

	}

/*
//Umm...some modules have no readgroup or no admingroup	
	function validateRead_groupid()
	{
		$groupid = $this->get('read_groupid');
		if (!(count($groupid))) {
			$this->addErrorMessage(_AD_XCORE_ERROR_GROUPID);
		}
	}
	
	function validateAdmin_groupid()
	{
		$groupid = $this->get('admin_groupid');
		if (!(count($groupid))) {
			$this->addErrorMessage(_AD_XCORE_ERROR_GROUPID);
		}
	}
*/
	function load(&$obj)
	{
		$this->set('mid', $obj->get('mid'));
		$this->set('name', $obj->get('name'));
		$this->set('weight', $obj->get('weight'));

		$root = Root::getSingleton();
		$module_cache = !empty($root->mContext->mXoopsConfig['module_cache'][$obj->get('mid')]) ? $root->mContext->mXoopsConfig['module_cache'][$obj->get('mid')]: 0;
		$this->set('module_cache', $module_cache);
	}

	function update(&$obj)
	{

		$obj->set('name', $this->get('name'));
		$obj->set('weight', $this->get('weight'));
	}
}

