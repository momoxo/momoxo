<?php

use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;
use XCore\Property\BoolProperty;
use XCore\Property\IntArrayProperty;
use XCore\Property\IntProperty;
use XCore\Property\StringProperty;

class Xcore_ImagecategoryAdminEditForm extends ActionForm
{
	function getTokenName()
	{
		return "module.xcore.ImagecategoryAdminEditForm.TOKEN" . $this->get('imgcat_id');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['imgcat_id'] =new IntProperty('imgcat_id');
		$this->mFormProperties['imgcat_name'] =new StringProperty('imgcat_name');
		$this->mFormProperties['imgcat_maxsize'] =new IntProperty('imgcat_maxsize');
		$this->mFormProperties['imgcat_maxwidth'] =new IntProperty('imgcat_maxwidth');
		$this->mFormProperties['imgcat_maxheight'] =new IntProperty('imgcat_maxheight');
		$this->mFormProperties['imgcat_display'] =new BoolProperty('imgcat_display');
		$this->mFormProperties['imgcat_weight'] =new IntProperty('imgcat_weight');
		$this->mFormProperties['readgroups'] =new IntArrayProperty('readgroups');
		$this->mFormProperties['uploadgroups'] =new IntArrayProperty('uploadgroups');

		//
		// Set field properties
		//
		$this->mFieldProperties['imgcat_id'] =new FieldProperty($this);
		$this->mFieldProperties['imgcat_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['imgcat_id']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_IMGCAT_ID);
	
		$this->mFieldProperties['imgcat_name'] =new FieldProperty($this);
		$this->mFieldProperties['imgcat_name']->setDependsByArray(array('required','maxlength'));
		$this->mFieldProperties['imgcat_name']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_IMGCAT_NAME, '100');
		$this->mFieldProperties['imgcat_name']->addMessage('maxlength', _MD_XCORE_ERROR_MAXLENGTH, _AD_XCORE_LANG_IMGCAT_NAME, '100');
		$this->mFieldProperties['imgcat_name']->addVar('maxlength', '100');
	
		$this->mFieldProperties['imgcat_maxsize'] =new FieldProperty($this);
		$this->mFieldProperties['imgcat_maxsize']->setDependsByArray(array('required'));
		$this->mFieldProperties['imgcat_maxsize']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_IMGCAT_MAXSIZE);
	
		$this->mFieldProperties['imgcat_maxwidth'] =new FieldProperty($this);
		$this->mFieldProperties['imgcat_maxwidth']->setDependsByArray(array('required'));
		$this->mFieldProperties['imgcat_maxwidth']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_IMGCAT_MAXWIDTH);
	
		$this->mFieldProperties['imgcat_maxheight'] =new FieldProperty($this);
		$this->mFieldProperties['imgcat_maxheight']->setDependsByArray(array('required'));
		$this->mFieldProperties['imgcat_maxheight']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_IMGCAT_MAXHEIGHT);
	
		$this->mFieldProperties['imgcat_weight'] =new FieldProperty($this);
		$this->mFieldProperties['imgcat_weight']->setDependsByArray(array('required'));
		$this->mFieldProperties['imgcat_weight']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_IMGCAT_WEIGHT);
	
		$this->mFieldProperties['readgroups'] =new FieldProperty($this);
		$this->mFieldProperties['readgroups']->setDependsByArray(array('objectExist'));
		$this->mFieldProperties['readgroups']->addMessage('objectExist', _AD_XCORE_ERROR_OBJECTEXIST, _AD_XCORE_LANG_IMGCAT_READ_GROUPS);
		$this->mFieldProperties['readgroups']->addVar('handler', 'group');
	
		$this->mFieldProperties['uploadgroups'] =new FieldProperty($this);
		$this->mFieldProperties['uploadgroups']->setDependsByArray(array('objectExist'));
		$this->mFieldProperties['uploadgroups']->addMessage('objectExist', _AD_XCORE_ERROR_OBJECTEXIST, _AD_XCORE_LANG_IMGCAT_UPLOAD_GROUPS);
		$this->mFieldProperties['uploadgroups']->addVar('handler', 'group');
	}

	function validateReadgroups()
	{
		$readgroups = $this->get('readgroups');
		if (count($readgroups) == 0) {
			$this->addErrorMessage(_AD_XCORE_ERROR_READGROUPS);
		}
	}
	
	function validateUploadgroups()
	{
		$uploadgroups = $this->get('uploadgroups');
		if (count($uploadgroups) == 0) {
			$this->addErrorMessage(_AD_XCORE_ERROR_UPLOADGROUPS);
		}
	}
	
	function load(&$obj)
	{
		$this->set('imgcat_id', $obj->get('imgcat_id'));
		$this->set('imgcat_name', $obj->get('imgcat_name'));
		$this->set('imgcat_maxsize', $obj->get('imgcat_maxsize'));
		$this->set('imgcat_maxwidth', $obj->get('imgcat_maxwidth'));
		$this->set('imgcat_maxheight', $obj->get('imgcat_maxheight'));
		$this->set('imgcat_display', $obj->get('imgcat_display'));
		$this->set('imgcat_weight', $obj->get('imgcat_weight'));
		
		$i = 0;
		foreach ($obj->mReadGroups as $group) {
			$this->set('readgroups', $i++, $group->get('groupid'));
		}

		$i = 0;
		foreach ($obj->mUploadGroups as $group) {
			$this->set('uploadgroups', $i++, $group->get('groupid'));
		}
	}

	function update(&$obj)
	{
		$obj->set('imgcat_id', $this->get('imgcat_id'));
		$obj->set('imgcat_name', $this->get('imgcat_name'));
		$obj->set('imgcat_maxsize', $this->get('imgcat_maxsize'));
		$obj->set('imgcat_maxwidth', $this->get('imgcat_maxwidth'));
		$obj->set('imgcat_maxheight', $this->get('imgcat_maxheight'));
		$obj->set('imgcat_display', $this->get('imgcat_display'));
		$obj->set('imgcat_weight', $this->get('imgcat_weight'));
		
		$handler =& xoops_gethandler('group');

		unset($obj->mReadGroups);
		foreach ($this->get('readgroups') as $groupid) {
			$obj->mReadGroups[] =& $handler->get($groupid);
		}
		
		unset($obj->mUploadGroups);
		foreach ($this->get('uploadgroups') as $groupid) {
			$obj->mUploadGroups[] =& $handler->get($groupid);
		}
	}
}

