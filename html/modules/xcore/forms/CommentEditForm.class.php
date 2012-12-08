<?php

use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;
use XCore\Property\BoolProperty;
use XCore\Property\IntProperty;
use XCore\Property\StringProperty;
use XCore\Property\TextProperty;

class Xcore_CommentEditForm extends ActionForm
{
	function getTokenName()
	{
		return "module.xcore.Xcore_CommentEditForm.TOKEN";
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['com_id'] =new IntProperty('com_id');
		$this->mFormProperties['com_pid'] =new IntProperty('com_pid');
		$this->mFormProperties['com_rootid'] =new IntProperty('com_rootid');
		$this->mFormProperties['com_modid'] =new IntProperty('com_modid');
		$this->mFormProperties['com_itemid'] =new IntProperty('com_itemid');
		$this->mFormProperties['com_icon'] =new StringProperty('com_icon');
		$this->mFormProperties['com_created'] =new IntProperty('com_created');
		$this->mFormProperties['com_modified'] =new IntProperty('com_modified');
		$this->mFormProperties['com_ip'] =new StringProperty('com_ip');
		$this->mFormProperties['com_title'] =new StringProperty('com_title');
		$this->mFormProperties['com_text'] =new TextProperty('com_text');
		$this->mFormProperties['com_sig'] =new BoolProperty('com_sig');
		$this->mFormProperties['com_status'] =new IntProperty('com_status');
		$this->mFormProperties['com_exparams'] =new StringProperty('com_exparams');
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

		$this->mFieldProperties['com_pid'] =new FieldProperty($this);
		$this->mFieldProperties['com_pid']->setDependsByArray(array('required'));
		$this->mFieldProperties['com_pid']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_XCORE_LANG_COM_PID);

		$this->mFieldProperties['com_rootid'] =new FieldProperty($this);
		$this->mFieldProperties['com_rootid']->setDependsByArray(array('required'));
		$this->mFieldProperties['com_rootid']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_XCORE_LANG_COM_ROOTID);

		$this->mFieldProperties['com_modid'] =new FieldProperty($this);
		$this->mFieldProperties['com_modid']->setDependsByArray(array('required'));
		$this->mFieldProperties['com_modid']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_XCORE_LANG_COM_MODID);

		$this->mFieldProperties['com_itemid'] =new FieldProperty($this);
		$this->mFieldProperties['com_itemid']->setDependsByArray(array('required'));
		$this->mFieldProperties['com_itemid']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_XCORE_LANG_COM_ITEMID);

		$this->mFieldProperties['com_icon'] =new FieldProperty($this);
		$this->mFieldProperties['com_icon']->setDependsByArray(array('required','maxlength'));
		$this->mFieldProperties['com_icon']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_XCORE_LANG_COM_ICON, '25');
		$this->mFieldProperties['com_icon']->addMessage('maxlength', _MD_XCORE_ERROR_MAXLENGTH, _MD_XCORE_LANG_COM_ICON, '25');
		$this->mFieldProperties['com_icon']->addVar('maxlength', 25);

		$this->mFieldProperties['com_ip'] =new FieldProperty($this);
		$this->mFieldProperties['com_ip']->setDependsByArray(array('required','maxlength'));
		$this->mFieldProperties['com_ip']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_XCORE_LANG_COM_IP, '15');
		$this->mFieldProperties['com_ip']->addMessage('maxlength', _MD_XCORE_ERROR_MAXLENGTH, _MD_XCORE_LANG_COM_IP, '15');
		$this->mFieldProperties['com_ip']->addVar('maxlength', 15);

		$this->mFieldProperties['com_title'] =new FieldProperty($this);
		$this->mFieldProperties['com_title']->setDependsByArray(array('required','maxlength'));
		$this->mFieldProperties['com_title']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_XCORE_LANG_COM_TITLE, '255');
		$this->mFieldProperties['com_title']->addMessage('maxlength', _MD_XCORE_ERROR_MAXLENGTH, _MD_XCORE_LANG_COM_TITLE, '255');
		$this->mFieldProperties['com_title']->addVar('maxlength', 255);

		$this->mFieldProperties['com_text'] =new FieldProperty($this);
		$this->mFieldProperties['com_text']->setDependsByArray(array('required'));
		$this->mFieldProperties['com_text']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_XCORE_LANG_COM_TEXT);

		$this->mFieldProperties['com_exparams'] =new FieldProperty($this);
		$this->mFieldProperties['com_exparams']->setDependsByArray(array('required','maxlength'));
		$this->mFieldProperties['com_exparams']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_XCORE_LANG_COM_EXPARAMS, '255');
		$this->mFieldProperties['com_exparams']->addMessage('maxlength', _MD_XCORE_ERROR_MAXLENGTH, _MD_XCORE_LANG_COM_EXPARAMS, '255');
		$this->mFieldProperties['com_exparams']->addVar('maxlength', 255);
	}

	function load(&$obj)
	{
		$this->set('com_id', $obj->get('com_id'));
		$this->set('com_pid', $obj->get('com_pid'));
		$this->set('com_rootid', $obj->get('com_rootid'));
		$this->set('com_modid', $obj->get('com_modid'));
		$this->set('com_itemid', $obj->get('com_itemid'));
		$this->set('com_icon', $obj->get('com_icon'));
		$this->set('com_created', $obj->get('com_created'));
		$this->set('com_modified', $obj->get('com_modified'));
		$this->set('com_ip', $obj->get('com_ip'));
		$this->set('com_title', $obj->get('com_title'));
		$this->set('com_text', $obj->get('com_text'));
		$this->set('com_sig', $obj->get('com_sig'));
		$this->set('com_status', $obj->get('com_status'));
		$this->set('com_exparams', $obj->get('com_exparams'));
		$this->set('dosmiley', $obj->get('dosmiley'));
		$this->set('doxcode', $obj->get('doxcode'));
		$this->set('doimage', $obj->get('doimage'));
		$this->set('dobr', $obj->get('dobr'));
	}

	function update(&$obj)
	{
		$obj->set('com_id', $this->get('com_id'));
		$obj->set('com_pid', $this->get('com_pid'));
		$obj->set('com_rootid', $this->get('com_rootid'));
		$obj->set('com_modid', $this->get('com_modid'));
		$obj->set('com_itemid', $this->get('com_itemid'));
		$obj->set('com_icon', $this->get('com_icon'));
		$obj->set('com_created', $this->get('com_created'));
		$obj->set('com_modified', time());

		//
		// TODO check NONAME form
		//	$obj->set('com_uid', $this->get('com_uid'));

		//
		// TODO  IP will be changed when a administrator will edit or a user will
		//      edit again.
		//
		$obj->set('com_ip', $_SERVER['REMOTE_ADDR']);
		$obj->set('com_title', $this->get('com_title'));
		$obj->set('com_text', $this->get('com_text'));
		$obj->set('com_sig', $this->get('com_sig'));
		$obj->set('com_status', $this->get('com_status'));
		$obj->set('com_exparams', $this->get('com_exparams'));
		$obj->set('dosmiley', $this->get('dosmiley'));
		$obj->set('doxcode', $this->get('doxcode'));
		$obj->set('doimage', $this->get('doimage'));
		$obj->set('dobr', $this->get('dobr'));
	}
}

class Xcore_CommentEditForm_Admin extends Xcore_CommentEditForm
{
	function prepare()
	{
		parent::prepare();
		
		//
		// Set form properties
		//
		$this->mFormProperties['dohtml'] =new BoolProperty('dohtml');
	}

	function load(&$obj)
	{
		parent::load($obj);

		$this->set('dohtml', $obj->get('dohtml'));
	}

	function update(&$obj)
	{
		update::load($obj);

		$obj->set('dohtml', $this->get('dohtml'));
	}
}

