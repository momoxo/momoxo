<?php

use XCore\Form\FieldProperty;

class Xcore_SearchShowallForm extends Xcore_SearchResultsForm
{
	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['mid'] =new XCube_IntProperty('mid');
		$this->mFormProperties['andor'] =new XCube_StringProperty('andor');
		$this->mFormProperties['query'] =new XCube_StringProperty('query');
		$this->mFormProperties['start'] =new XCube_IntProperty('start');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['andor'] =new FieldProperty($this);
		$this->mFieldProperties['andor']->setDependsByArray(array('mask'));
		$this->mFieldProperties['andor']->addMessage('mask', _MD_XCORE_ERROR_MASK, _MD_XCORE_LANG_ANDOR);
		$this->mFieldProperties['andor']->addVar('mask', '/^(AND|OR|exact)$/i');

		$this->set('start', 0);
	}
	
	function update(&$params)
	{
		$params['queries'] = $this->mQueries;
		$params['andor'] = $this->get('andor');
		$params['maxhit'] = XCORE_SEARCH_SHOWALL_MAXHIT;
		$params['start'] = $this->get('start');
	}
}

