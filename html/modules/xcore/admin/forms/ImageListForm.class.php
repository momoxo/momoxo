<?php

/**
 * This class is generated by makeActionForm tool.
 * @auchor makeActionForm
 */
use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;
use XCore\Property\BoolArrayProperty;
use XCore\Property\BoolProperty;
use XCore\Property\IntArrayProperty;
use XCore\Property\StringArrayProperty;

class Xcore_ImageListForm extends ActionForm
{
	/**
	 * If the request is GET, never return token name.
	 * By this logic, a action can have three page in one action.
	 */
	function getTokenName()
	{
		//
		//
		if (xoops_getenv('REQUEST_METHOD') == 'POST') {
			return "module.xcore.ImageSettingsForm.TOKEN";
		}
		else {
			return null;
		}
	}
	
	/**
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
		$this->mFormProperties['nicename']=new StringArrayProperty('nicename');
		$this->mFormProperties['weight']=new IntArrayProperty('weight');
		$this->mFormProperties['display']=new BoolArrayProperty('display');
		$this->mFormProperties['delete']=new BoolArrayProperty('delete');
		//to display error-msg at confirm-page
		$this->mFormProperties['confirm'] =new BoolProperty('confirm');
		// set fields
		$this->mFieldProperties['nicename'] =new FieldProperty($this);
		$this->mFieldProperties['nicename']->setDependsByArray(array('required'));
		$this->mFieldProperties['nicename']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_XCORE_LANG_IMAGE_NICENAME);

		$this->mFieldProperties['weight'] =new FieldProperty($this);
		$this->mFieldProperties['weight']->setDependsByArray(array('required'));
		$this->mFieldProperties['weight']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_IMAGE_WEIGHT);

	}
}

