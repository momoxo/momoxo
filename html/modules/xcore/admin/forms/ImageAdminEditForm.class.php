<?php

use XCore\Form\FieldProperty;

class Xcore_ImageAdminCreateForm extends Xcore_ImageUploadForm
{
	var $_mImgcatId = 0;
	
	function getTokenName()
	{
		return "module.xcore.ImageAdminEditForm.TOKEN" . $this->get('image_id');
	}

	function prepare()
	{
		parent::prepare();
		
		//
		// Set form properties
		//
		$this->mFormProperties['image_id'] =new XCube_IntProperty('image_id');
		$this->mFormProperties['image_display'] =new XCube_BoolProperty('image_display');
		$this->mFormProperties['image_weight'] =new XCube_IntProperty('image_weight');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['image_id'] =new FieldProperty($this);
		$this->mFieldProperties['image_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['image_id']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_IMAGE_ID);
	
		$this->mFieldProperties['image_weight'] =new FieldProperty($this);
		$this->mFieldProperties['image_weight']->setDependsByArray(array('required'));
		$this->mFieldProperties['image_weight']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_IMAGE_WEIGHT);
	}
	
	function load(&$obj)
	{
		parent::load($obj);
		$this->set('image_id', $obj->get('image_id'));
		$this->set('image_display', $obj->get('image_display'));
		$this->set('image_weight', $obj->get('image_weight'));
		
		$this->_mImgcatId = $obj->get('imgcat_id');
	}
	
	function update(&$obj)
	{
		parent::update($obj);
		$obj->set('image_id', $this->get('image_id'));
		$obj->set('image_display', $this->get('image_display'));
		$obj->set('image_weight', $this->get('image_weight'));
	}
}

class Xcore_ImageAdminEditForm extends Xcore_ImageAdminCreateForm
{
	function validateImgcat_id()
	{
		parent::validateImgcat_id();
		
		$handler =& xoops_getmodulehandler('imagecategory', 'xcore');
		$currentCategory =& $handler->get($this->_mImgcatId);
		
		$specificCategory =& $handler->get($this->get('imgcat_id'));
		if ($currentCategory->get('imgcat_storetype') != $specificCategory->get('imgcat_storetype')) {
			$this->set('imgcat_id', $this->_mImgcatId);
		}
	}
}

