<?php

use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;

class User_RanksAdminDeleteForm extends ActionForm
{
	function getTokenName()
	{
		return "module.user.RanksAdminDeleteForm.TOKEN" . $this->get('rank_id');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['rank_id'] =new XCube_IntProperty('rank_id');

		//
		// Set field properties
		//
		$this->mFieldProperties['rank_id'] =new FieldProperty($this);
		$this->mFieldProperties['rank_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['rank_id']->addMessage('required', _MD_USER_ERROR_REQUIRED, _MD_USER_LANG_RANK_ID);
	}

	function load(&$obj)
	{
		$this->set('rank_id', $obj->get('rank_id'));
	}

	function update(&$obj)
	{
		$obj->setVar('rank_id', $this->get('rank_id'));
	}
}

?>
