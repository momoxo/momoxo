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

class User_RanksListForm extends ActionForm
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
			return "module.user.RanksSettingsForm.TOKEN";
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
		$this->mFormProperties['title'] =new StringArrayProperty('title');
		$this->mFormProperties['min'] =new IntArrayProperty('min');
		$this->mFormProperties['max'] =new IntArrayProperty('max');
		$this->mFormProperties['delete']= new BoolArrayProperty('delete');
		//to display error-msg at confirm-page
		$this->mFormProperties['confirm'] =new BoolProperty('confirm');

		$this->mFieldProperties['title'] =new FieldProperty($this);
		$this->mFieldProperties['title']->setDependsByArray(array('required','maxlength'));
		$this->mFieldProperties['title']->addMessage('required', _MD_USER_ERROR_REQUIRED, _AD_USER_LANG_RANK_TITLE, '50');
		$this->mFieldProperties['title']->addMessage('maxlength', _MD_USER_ERROR_MAXLENGTH, _AD_USER_LANG_RANK_TITLE, '50');
		$this->mFieldProperties['title']->addVar('maxlength', 50);

		$this->mFieldProperties['min'] =new FieldProperty($this);
		$this->mFieldProperties['min']->setDependsByArray(array('required', 'min'));
		$this->mFieldProperties['min']->addMessage('required', _MD_USER_ERROR_REQUIRED, _AD_USER_LANG_RANK_MIN);
		$this->mFieldProperties['min']->addMessage('min', _AD_USER_ERROR_MIN, _AD_USER_LANG_RANK_MIN, 0);
		$this->mFieldProperties['min']->addVar('min', 0);

		$this->mFieldProperties['max'] =new FieldProperty($this);
		$this->mFieldProperties['max']->setDependsByArray(array('required', 'min'));
		$this->mFieldProperties['max']->addMessage('required', _MD_USER_ERROR_REQUIRED, _AD_USER_LANG_RANK_MAX);
		$this->mFieldProperties['max']->addMessage('min', _AD_USER_ERROR_MIN, _AD_USER_LANG_RANK_MAX, 0);
		$this->mFieldProperties['max']->addVar('min', 0);

	}
}

?>
