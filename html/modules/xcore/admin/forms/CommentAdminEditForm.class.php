<?php

use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;
use XCore\Property\BoolProperty;
use XCore\Property\IntProperty;
use XCore\Property\StringProperty;
use XCore\Property\TextProperty;

class Xcore_AbstractCommentAdminEditForm extends ActionForm
{
	function getTokenName()
	{
		return "module.xcore.CommentAdminEditForm.TOKEN" . $this->get('com_id');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['com_id'] =new IntProperty('com_id');
		$this->mFormProperties['com_icon'] =new StringProperty('com_icon');
		$this->mFormProperties['com_title'] =new StringProperty('com_title');
		$this->mFormProperties['com_text'] =new TextProperty('com_text');
		$this->mFormProperties['com_sig'] =new BoolProperty('com_sig');
		$this->mFormProperties['com_status'] =new IntProperty('com_status');
		$this->mFormProperties['dohtml'] =new BoolProperty('dohtml');
		$this->mFormProperties['dosmiley'] =new BoolProperty('dosmiley');
		$this->mFormProperties['doxcode'] =new BoolProperty('doxcode');
		$this->mFormProperties['doimage'] =new BoolProperty('doimage');
		$this->mFormProperties['dobr'] =new BoolProperty('dobr');
	
		//
		// Set field properties
		//
	
		$this->mFieldProperties['com_id'] =new FieldProperty($this);
		$this->mFieldProperties['com_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['com_id']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_XCORE_LANG_COM_ID);
	
		$this->mFieldProperties['com_icon'] =new FieldProperty($this);
		$this->mFieldProperties['com_icon']->setDependsByArray(array('maxlength'));
		$this->mFieldProperties['com_icon']->addMessage('maxlength', _MD_XCORE_ERROR_MAXLENGTH, _MD_XCORE_LANG_COM_ICON, '25');
		$this->mFieldProperties['com_icon']->addVar('maxlength', '25');
	
		$this->mFieldProperties['com_title'] =new FieldProperty($this);
		$this->mFieldProperties['com_title']->setDependsByArray(array('required','maxlength'));
		$this->mFieldProperties['com_title']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_XCORE_LANG_COM_TITLE, '255');
		$this->mFieldProperties['com_title']->addMessage('maxlength', _MD_XCORE_ERROR_MAXLENGTH, _MD_XCORE_LANG_COM_TITLE, '255');
		$this->mFieldProperties['com_title']->addVar('maxlength', '255');
	
		$this->mFieldProperties['com_text'] =new FieldProperty($this);
		$this->mFieldProperties['com_text']->setDependsByArray(array('required'));
		$this->mFieldProperties['com_text']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_XCORE_LANG_COM_TEXT);
	}

	function load(&$obj)
	{
		$this->set('com_id', $obj->get('com_id'));
		$this->set('com_icon', $obj->get('com_icon'));
		$this->set('com_title', $obj->get('com_title'));
		$this->set('com_text', $obj->get('com_text'));
		$this->set('com_sig', $obj->get('com_sig'));
		$this->set('com_status', $obj->get('com_status'));
		$this->set('dohtml', $obj->get('dohtml'));
		$this->set('dosmiley', $obj->get('dosmiley'));
		$this->set('doxcode', $obj->get('doxcode'));
		$this->set('doimage', $obj->get('doimage'));
		$this->set('dobr', $obj->get('dobr'));
	}

	function update(&$obj)
	{
		$obj->set('com_id', $this->get('com_id'));
		$obj->set('com_icon', $this->get('com_icon'));
		$obj->set('com_title', $this->get('com_title'));
		$obj->set('com_text', $this->get('com_text'));
		$obj->set('com_sig', $this->get('com_sig'));
		$obj->set('com_status', $this->get('com_status'));
		$obj->set('dohtml', $this->get('dohtml'));
		$obj->set('dosmiley', $this->get('dosmiley'));
		$obj->set('doxcode', $this->get('doxcode'));
		$obj->set('doimage', $this->get('doimage'));
		$obj->set('dobr', $this->get('dobr'));
	}
}

class Xcore_PendingCommentAdminEditForm extends Xcore_AbstractCommentAdminEditForm
{
	function prepare()
	{
		parent::prepare();

		$this->mFieldProperties['com_status'] =new FieldProperty($this);
		$this->mFieldProperties['com_status']->setDependsByArray(array('required','intRange'));
		$this->mFieldProperties['com_status']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_COM_STATUS);
		$this->mFieldProperties['com_status']->addMessage('intRange', _AD_XCORE_ERROR_INTRANGE, _AD_XCORE_LANG_COM_STATUS);
		$this->mFieldProperties['com_status']->addVar('min', '1');
		$this->mFieldProperties['com_status']->addVar('max', '3');
	}
}

class Xcore_ApprovalCommentAdminEditForm extends Xcore_AbstractCommentAdminEditForm
{
	function prepare()
	{
		parent::prepare();

		$this->mFieldProperties['com_status'] =new FieldProperty($this);
		$this->mFieldProperties['com_status']->setDependsByArray(array('required','intRange'));
		$this->mFieldProperties['com_status']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_COM_STATUS);
		$this->mFieldProperties['com_status']->addMessage('intRange', _AD_XCORE_ERROR_INTRANGE, _AD_XCORE_LANG_COM_STATUS);
		$this->mFieldProperties['com_status']->addVar('min', '2');
		$this->mFieldProperties['com_status']->addVar('max', '3');
	}
}


