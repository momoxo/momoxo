<?php

use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;
use XCore\Property\StringProperty;

class Xcore_ActionSearchForm extends ActionForm
{
	var $mState = null;
	
	function prepare()
	{
		$this->mFormProperties['keywords']=new StringProperty('keywords');

		// set fields
		$this->mFieldProperties['keywords']=new FieldProperty($this);
		$this->mFieldProperties['keywords']->setDependsByArray(array('required'));
		$this->mFieldProperties['keywords']->addMessage("required",_AD_XCORE_ERROR_SEARCH_REQUIRED);
	}

	function fetch()
	{
		parent::fetch();
		$this->set('keywords', trim($this->get('keywords')));
	}
}	
