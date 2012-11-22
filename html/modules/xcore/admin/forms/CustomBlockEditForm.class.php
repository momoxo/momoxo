<?php

class Xcore_CustomBlockEditForm extends Xcore_BlockEditForm
{
	function getTokenName()
	{
		return "module.xcore.CustomBlockEditForm.TOKEN" . $this->get('bid');
	}

	function prepare()
	{
		parent::prepare();
		
		//
		// Set form properties
		//
		$this->mFormProperties['content'] =new XCube_TextProperty('content');
		$this->mFormProperties['c_type'] =new XCube_StringProperty('c_type');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['content'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['content']->setDependsByArray(array('required'));
		$this->mFieldProperties['content']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_CONTENT);
	
		$this->mFieldProperties['c_type'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['c_type']->setDependsByArray(array('required','maxlength'));
		$this->mFieldProperties['c_type']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_C_TYPE, '1');
		$this->mFieldProperties['c_type']->addMessage('maxlength', _MD_XCORE_ERROR_MAXLENGTH, _AD_XCORE_LANG_C_TYPE, '1');
		$this->mFieldProperties['c_type']->addVar('maxlength', '1');
	}
	
	function load(&$obj)
	{
		parent::load($obj);
		$this->set('content', $obj->get('content'));
		$this->set('c_type', $obj->get('c_type'));
	}

	function update(&$obj)
	{
		parent::update($obj);
		$obj->set('content', $this->get('content'));
		$obj->set('block_type', 'C');
		$obj->set('c_type', $this->get('c_type'));
		$obj->set('visible', 1);
		$obj->set('isactive', 1);
		
		switch ($this->get('c_type')) {
			case 'H':
				$obj->set('name', _AD_XCORE_LANG_CUSTOM_HTML);
				break;
			
			case 'P':
				$obj->set('name', _AD_XCORE_LANG_CUSTOM_PHP);
				break;
				
			case 'S':
				$obj->set('name', _AD_XCORE_LANG_CUSTOM_WITH_SMILIES);
				break;
				
			case 'T':
				$obj->set('name', _AD_XCORE_LANG_CUSTOM_WITHOUT_SMILIES);
				break;
		}
	}
}

