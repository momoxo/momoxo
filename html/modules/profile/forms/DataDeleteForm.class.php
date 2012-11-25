<?php

class Profile_DataDeleteForm extends XCube_ActionForm
{
	/**
	 * @public
	 */
	function getTokenName()
	{
		return "module.profile.DataDeleteForm.TOKEN";
	}

	/**
	 * @public
	 */
	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['uid'] =new XCube_IntProperty('uid');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['uid'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['uid']->setDependsByArray(array('required'));
		$this->mFieldProperties['uid']->addMessage('required', _MD_PROFILE_ERROR_REQUIRED, _MD_PROFILE_LANG_UID);
	}

	/**
	 * @public
	 */
	function load(&$obj)
	{
		$this->set('uid', $obj->get('uid'));
	}

	/**
	 * @public
	 */
	function update(&$obj)
	{
		$obj->set('uid', $this->get('uid'));
	}
}

?>
