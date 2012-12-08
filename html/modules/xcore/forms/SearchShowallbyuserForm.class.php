<?php

use XCore\Form\FieldProperty;
use XCore\Property\IntProperty;

class Xcore_SearchShowallbyuserForm extends Xcore_SearchShowallForm
{
	function prepare()
	{
		parent::prepare();
		
		//
		// Set form properties
		//
		$this->mFormProperties['uid'] =new IntProperty('uid');
		$this->mFormProperties['mid'] =new IntProperty('mid');
		$this->mFormProperties['start'] =new IntProperty('start');
		
		//
		// Set field properties
		//
		$this->mFieldProperties['uid'] =new FieldProperty($this);
		$this->mFieldProperties['uid']->setDependsByArray(array('required'));
		$this->mFieldProperties['uid']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_XCORE_LANG_UID);
		
		$this->mFieldProperties['mid'] =new FieldProperty($this);
		$this->mFieldProperties['mid']->setDependsByArray(array('required'));
		$this->mFieldProperties['mid']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_XCORE_LANG_MID);
	}
	
	function update(&$params)
	{
		$params['uid'] = $this->get('uid');
		$params['start'] = $this->get('start');
		
		if (defined("XCORE_SEARCH_SHOWALL_MAXHIT")) {
			$params['maxhit'] = XCORE_SEARCH_SHOWALL_MAXHIT;
		}
		else {
			$params['maxhit'] = 20;
		}
	}
}

