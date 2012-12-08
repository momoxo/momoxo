<?php

use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;
use XCore\Property\BoolArrayProperty;
use XCore\Property\IntArrayProperty;
use XCore\Property\StringArrayProperty;

class Xcore_ModuleListForm extends ActionForm
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
			return "module.xcore.ModuleSettingsForm.TOKEN";
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
		$this->mFormProperties['name']=new StringArrayProperty('name');
		$this->mFormProperties['weight']=new IntArrayProperty('weight');
		$this->mFormProperties['isactive']=new BoolArrayProperty('isactive');
        $this->mFormProperties['issystem']=new BoolArrayProperty('issystem');

		// set fields
		$this->mFieldProperties['name']=new FieldProperty($this);
		$this->mFieldProperties['name']->setDependsByArray(array('required','maxlength'));
		$this->mFieldProperties['name']->addMessage("required",_MD_XCORE_ERROR_REQUIRED,_AD_XCORE_LANG_NAME,"140");
		$this->mFieldProperties['name']->addMessage("maxlength",_MD_XCORE_ERROR_MAXLENGTH,_AD_XCORE_LANG_NAME,"140");
		$this->mFieldProperties['name']->addVar("maxlength",140);

		$this->mFieldProperties['weight']=new FieldProperty($this);
		$this->mFieldProperties['weight']->setDependsByArray(array('required','min'));
		$this->mFieldProperties['weight']->addMessage("min",_AD_XCORE_ERROR_MIN,_AD_XCORE_LANG_WEIGHT,"0");
		$this->mFieldProperties['weight']->addVar("min",0);
	}
}

