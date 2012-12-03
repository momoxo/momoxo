<?php

use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;

class Xupdate_Admin_ModuleStoreForm extends ActionForm
{
	/***
	 * If the request is GET, never return token name.
	 * By this logic, a action can have three page in one action.
	 */
	function getTokenName()
	{
		//
		//
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			return "module.xupdate.Admin_ModuleStorForm.TOKEN";
		}
		else {
			return null;
		}
	}
	/***
	 * For displaying the confirm-page, don't show CSRF error.
	 * Always return null.
	 */
	function getTokenErrorMessage()
	{
		return null;
	}


	function prepare()
	{
		// set properties
		$this->mFormProperties['dirname']=new XCube_StringArrayProperty('dirname');

		// set fields
		$this->mFieldProperties['dirname']=new FieldProperty($this);
		$this->mFieldProperties['dirname']->setDependsByArray(array('required','maxlength'));
		$this->mFieldProperties['dirname']->addMessage("required",_MD_XUPDATE_ERROR_REQUIRED,_MD_XUPDATE_LANG_NAME,"255");
		$this->mFieldProperties['dirname']->addMessage("maxlength",_MD_XUPDATE_ERROR_MAXLENGTH,_MD_XUPDATE_LANG_NAME,"255");
		$this->mFieldProperties['dirname']->addVar("maxlength",255);

	}


}

?>