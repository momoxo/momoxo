<?php

/***
 * @internal
 * @public
 * @todo We may rename this class.
 */
use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;
use XCore\Property\BoolArrayProperty;
use XCore\Property\BoolProperty;
use XCore\Property\IntArrayProperty;
use XCore\Property\StringArrayProperty;

class Xcore_BlockListForm extends ActionForm
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
			return "module.xcore.BlockListForm.TOKEN";
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
		//
		// Set form properties
		//
		$this->mFormProperties['title'] =new StringArrayProperty('title');
		$this->mFormProperties['weight'] =new IntArrayProperty('weight');
		$this->mFormProperties['side'] =new IntArrayProperty('side');
		$this->mFormProperties['bcachetime'] =new IntArrayProperty('bcachetime');
		$this->mFormProperties['uninstall']=new BoolArrayProperty('uninstall');
		//to display error-msg at confirm-page
		$this->mFormProperties['confirm'] =new BoolProperty('confirm');

		//
		// Set field properties
		//
		$this->mFieldProperties['title'] =new FieldProperty($this);
		$this->mFieldProperties['title']->setDependsByArray(array('required','maxlength'));
		$this->mFieldProperties['title']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_TITLE, '255');
		$this->mFieldProperties['title']->addMessage('maxlength', _MD_XCORE_ERROR_MAXLENGTH, _AD_XCORE_LANG_TITLE, '255');
		$this->mFieldProperties['title']->addVar('maxlength', '255');

		$this->mFieldProperties['weight'] =new FieldProperty($this);
		$this->mFieldProperties['weight']->setDependsByArray(array('required','intRange'));
		$this->mFieldProperties['weight']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_WEIGHT);
		$this->mFieldProperties['weight']->addMessage('intRange', _AD_XCORE_ERROR_INTRANGE, _AD_XCORE_LANG_WEIGHT);
		$this->mFieldProperties['weight']->addVar('min', '0');
		$this->mFieldProperties['weight']->addVar('max', '65535');
	
		$this->mFieldProperties['side'] =new FieldProperty($this);
		$this->mFieldProperties['side']->setDependsByArray(array('required','objectExist'));
		$this->mFieldProperties['side']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_SIDE);
		$this->mFieldProperties['side']->addMessage('objectExist', _AD_XCORE_ERROR_OBJECTEXIST, _AD_XCORE_LANG_SIDE);
		$this->mFieldProperties['side']->addVar('handler', 'columnside');
		$this->mFieldProperties['side']->addVar('module', 'xcore');
	
		$this->mFieldProperties['bcachetime'] =new FieldProperty($this);
		$this->mFieldProperties['bcachetime']->setDependsByArray(array('required','objectExist'));
		$this->mFieldProperties['bcachetime']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_BCACHETIME);
		$this->mFieldProperties['bcachetime']->addMessage('objectExist', _AD_XCORE_ERROR_OBJECTEXIST, _AD_XCORE_LANG_BCACHETIME);
		$this->mFieldProperties['bcachetime']->addVar('handler', 'cachetime');
	}
}

