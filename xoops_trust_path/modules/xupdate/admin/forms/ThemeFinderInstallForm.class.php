<?php

use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;
use XCore\Property\IntProperty;
use XCore\Property\StringProperty;
use XCore\Entity\SimpleObject;

class Xupdate_Admin_ThemeFinderInstallForm extends ActionForm
{
	/**
	 * getTokenName
	 *
	 * @param   void
	 *
	 * @return  string
	**/
		function getTokenName()
	{
		return "module.xupdate.Admin_ThemeFinderInstallForm.TOKEN";
	}
	/***
	 * For displaying the confirm-page, don't show CSRF error.
	 * Always return null.
	 */
	function getTokenErrorMessage()
	{
		return null;
	}
	/**
	 * prepare
	 *
	 * @param   void
	 *
	 * @return  void
	**/
	public function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['addon_url'] = new StringProperty('addon_url');

		$this->mFormProperties['target_key'] = new IntProperty('target_key');
		$this->mFormProperties['target_type'] = new StringProperty('target_type');

		//
		// Set field properties
		//
		$this->mFieldProperties['target_key'] = new FieldProperty($this);
		$this->mFieldProperties['target_key']->setDependsByArray(array('required'));
		$this->mFieldProperties['target_key']->addMessage('required', _MD_XUPDATE_ERROR_REQUIRED, 'target_key');

		$this->mFieldProperties['target_type'] = new FieldProperty($this);
		$this->mFieldProperties['target_type']->setDependsByArray(array('required'));
		$this->mFieldProperties['target_type']->addMessage('required', _MD_XUPDATE_ERROR_REQUIRED, 'target_type');


	}

	/**
	 * load
	 *
	 * @param   SimpleObject  &$obj
	 *
	 * @return  void
	**/
	public function load(/*** SimpleObject ***/ &$obj)
	{
	}

	/**
	 * update
	 *
	 * @param   SimpleObject  &$obj
	 *
	 * @return  void
	**/
	public function update(/*** SimpleObject ***/ &$obj)
	{

	}

}//END CLASS

?>