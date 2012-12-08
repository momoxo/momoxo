<?php

/***
 * @internal
 */
use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;
use XCore\Property\IntProperty;
use XCore\Property\StringProperty;

class Xcore_CommentAdminDeleteForm extends ActionForm
{
	function getTokenName()
	{
		return "module.xcore.XoopscommentsAdminDeleteForm.TOKEN" . $this->get('com_id');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['com_id'] =new IntProperty('com_id');
		$this->mFormProperties['delete_mode'] =new StringProperty('delete_mode');

		//
		// Set field properties
		//
		$this->mFieldProperties['com_id'] =new FieldProperty($this);
		$this->mFieldProperties['com_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['com_id']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_XCORE_LANG_COM_ID);
	}

	function load(&$obj)
	{
		$this->setVar('com_id', $obj->get('com_id'));
	}

	function update(&$obj)
	{
		$obj->setVar('com_id', $this->get('com_id'));
	}
}

