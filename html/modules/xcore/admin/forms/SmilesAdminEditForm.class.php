<?php

class Xcore_SmilesAdminEditForm extends XCube_ActionForm
{
	var $mOldFileName = null;
	var $_mIsNew = null;
	var $mFormFile = null;

	function getTokenName()
	{
		return "module.xcore.SmilesAdminEditForm.TOKEN" . $this->get('id');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['id'] =new XCube_IntProperty('id');
		$this->mFormProperties['code'] =new XCube_StringProperty('code');
		$this->mFormProperties['smile_url'] =new XCube_ImageFileProperty('smile_url');
		$this->mFormProperties['emotion'] =new XCube_StringProperty('emotion');
		$this->mFormProperties['display'] =new XCube_BoolProperty('display');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['id'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['id']->setDependsByArray(array('required'));
		$this->mFieldProperties['id']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_ID);
	
		$this->mFieldProperties['code'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['code']->setDependsByArray(array('required','maxlength'));
		$this->mFieldProperties['code']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_XCORE_LANG_CODE, '50');
		$this->mFieldProperties['code']->addMessage('maxlength', _MD_XCORE_ERROR_MAXLENGTH, _MD_XCORE_LANG_CODE, '50');
		$this->mFieldProperties['code']->addVar('maxlength', '50');
	
		$this->mFieldProperties['smile_url'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['smile_url']->setDependsByArray(array('extension'));
		$this->mFieldProperties['smile_url']->addMessage('extension', _AD_XCORE_ERROR_EXTENSION);
		$this->mFieldProperties['smile_url']->addVar('extension', 'jpg,gif,png');
	
		$this->mFieldProperties['emotion'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['emotion']->setDependsByArray(array('required','maxlength'));
		$this->mFieldProperties['emotion']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_XCORE_LANG_EMOTION, '75');
		$this->mFieldProperties['emotion']->addMessage('maxlength', _MD_XCORE_ERROR_MAXLENGTH, _MD_XCORE_LANG_EMOTION, '75');
		$this->mFieldProperties['emotion']->addVar('maxlength', '75');
	}

	function validateSmile_url()
	{
		if ($this->_mIsNew && $this->get('smile_url') == null) {
			$this->addErrorMessage(XCube_Utils::formatMessage(_MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_SMILE_URL));
		}
	}

	function load(&$obj)
	{
		$this->set('id', $obj->get('id'));
		$this->set('code', $obj->get('code'));
		$this->set('emotion', $obj->get('emotion'));
		$this->set('display', $obj->get('display'));
		
		$this->_mIsNew = $obj->isNew();
		$this->mOldFileName = $obj->get('smile_url');
	}

	function update(&$obj)
	{
		$obj->set('id', $this->get('id'));
		$obj->set('code', $this->get('code'));
		$obj->set('emotion', $this->get('emotion'));
		$obj->set('display', $this->get('display'));
		
		$this->mFormFile = $this->get('smile_url');
		if ($this->mFormFile != null) {
			$this->mFormFile->setRandomToBodyName('smil');	// Fix your prefix
			$obj->set('smile_url', $this->mFormFile->getFileName());
		}
	}
}

?>
