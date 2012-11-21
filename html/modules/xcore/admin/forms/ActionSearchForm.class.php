<?php

class Xcore_ActionSearchForm extends XCube_ActionForm
{
	var $mState = null;
	
	function prepare()
	{
		$this->mFormProperties['keywords']=new XCube_StringProperty('keywords');

		// set fields
		$this->mFieldProperties['keywords']=new XCube_FieldProperty($this);
		$this->mFieldProperties['keywords']->setDependsByArray(array('required'));
		$this->mFieldProperties['keywords']->addMessage("required",_AD_XCORE_ERROR_SEARCH_REQUIRED);
	}

	function fetch()
	{
		parent::fetch();
		$this->set('keywords', trim($this->get('keywords')));
	}
}	
