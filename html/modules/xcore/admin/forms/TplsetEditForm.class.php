<?php

use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;
use XCore\Property\IntProperty;
use XCore\Property\StringProperty;
use XCore\Property\TextProperty;

class Xcore_TplsetEditForm extends ActionForm
{
	function getTokenName()
	{
		return "module.xcore.TplsetEditForm.TOKEN" . $this->get('tplset_id');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['tplset_id'] =new IntProperty('tplset_id');
		$this->mFormProperties['tplset_desc'] =new StringProperty('tplset_desc');
		$this->mFormProperties['tplset_credits'] =new TextProperty('tplset_credits');

		//
		// Set field properties
		//
		$this->mFieldProperties['tplset_id'] =new FieldProperty($this);
		$this->mFieldProperties['tplset_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['tplset_id']->addMessage('required', _AD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_TPLSET_ID);

		$this->mFieldProperties['tplset_desc'] =new FieldProperty($this);
		$this->mFieldProperties['tplset_desc']->setDependsByArray(array('maxlength'));
		$this->mFieldProperties['tplset_desc']->addMessage('maxlength', _AD_XCORE_ERROR_MAXLENGTH, _AD_XCORE_LANG_TPLSET_DESC, '255');
		$this->mFieldProperties['tplset_desc']->addVar('maxlength', 255);
	}

	function load(&$obj)
	{
		$this->set('tplset_id', $obj->get('tplset_id'));
		$this->set('tplset_desc', $obj->get('tplset_desc'));
		$this->set('tplset_credits', $obj->get('tplset_credits'));
	}

	function update(&$obj)
	{
		$obj->set('tplset_id', $this->get('tplset_id'));
		$obj->set('tplset_desc', $this->get('tplset_desc'));
		$obj->set('tplset_credits', $this->get('tplset_credits'));
	}
}

