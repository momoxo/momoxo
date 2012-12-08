<?php

use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;
use XCore\Property\IntProperty;
use XCore\Property\StringProperty;

class Xupdate_Admin_ModuleInstallForm extends ActionForm
{
	/**
	 * getTokenName
	 *
	 * @param   void
	 *
	 * @return  string
	**/
		function getTokenName()
	{
		return "module.xupdate.Admin_ModuleInstallForm.TOKEN";
	}
	/**
	 * prepare
	 *
	 * @param   void
	 *
	 * @return  void
	**/
	public function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['id'] = new IntProperty('id');
		$this->mFormProperties['sid'] = new IntProperty('sid');

		$this->mFormProperties['addon_url'] = new StringProperty('addon_url');

		$this->mFormProperties['trust_dirname'] = new StringProperty('trust_dirname');
		$this->mFormProperties['dirname'] = new StringProperty('dirname');

		$this->mFormProperties['target_key'] = new StringProperty('target_key');
		$this->mFormProperties['target_type'] = new StringProperty('target_type');

		$this->mFormProperties['unzipdirlevel'] = new StringProperty('unzipdirlevel');

		$this->mFormProperties['license'] = new StringProperty('license');
		$this->mFormProperties['required'] = new StringProperty('required');

		//
		// Set field properties
		//
		$this->mFieldProperties['id'] = new FieldProperty($this);
		$this->mFieldProperties['id']->setDependsByArray(array('required'));
		$this->mFieldProperties['id']->addMessage('required', _MD_XUPDATE_ERROR_REQUIRED, 'id');
		$this->mFieldProperties['sid'] = new FieldProperty($this);
		$this->mFieldProperties['sid']->setDependsByArray(array('required'));
		$this->mFieldProperties['sid']->addMessage('required', _MD_XUPDATE_ERROR_REQUIRED, _MD_XUPDATE_LANG_SID);

		$this->mFieldProperties['addon_url'] = new FieldProperty($this);
		$this->mFieldProperties['addon_url']->setDependsByArray(array('required'));
		$this->mFieldProperties['addon_url']->addMessage('required', _MD_XUPDATE_ERROR_REQUIRED, 'addon_url');

		$this->mFieldProperties['trust_dirname'] = new FieldProperty($this);
		$this->mFieldProperties['trust_dirname']->setDependsByArray(array('maxlength'));
		$this->mFieldProperties['trust_dirname']->addMessage("maxlength",_MD_XUPDATE_ERROR_MAXLENGTH,'trust_dirname',"255");
		$this->mFieldProperties['trust_dirname']->addVar("maxlength",25);

		$this->mFieldProperties['dirname'] = new FieldProperty($this);
		$this->mFieldProperties['dirname']->setDependsByArray(array('required','maxlength'));
		$this->mFieldProperties['dirname']->addMessage("required",_MD_XUPDATE_ERROR_REQUIRED,_MD_XUPDATE_LANG_NAME,"255");
		$this->mFieldProperties['dirname']->addMessage("maxlength",_MD_XUPDATE_ERROR_MAXLENGTH,_MD_XUPDATE_LANG_NAME,"255");
		$this->mFieldProperties['dirname']->addVar("maxlength",255);

		$this->mFieldProperties['target_key'] = new FieldProperty($this);
		$this->mFieldProperties['target_key']->setDependsByArray(array('required'));
		$this->mFieldProperties['target_key']->addMessage('required', _MD_XUPDATE_ERROR_REQUIRED, 'target_key');

		$this->mFieldProperties['target_type'] = new FieldProperty($this);
		$this->mFieldProperties['target_type']->setDependsByArray(array('required'));
		$this->mFieldProperties['target_type']->addMessage('required', _MD_XUPDATE_ERROR_REQUIRED, 'target_type');

		$this->mFormProperties['html_only'] = new IntProperty('html_only');

		$this->mFieldProperties['license'] = new FieldProperty($this);
		$this->mFieldProperties['required'] = new FieldProperty($this);
	}

	/**
	 * load
	 *
	 * @param   XoopsSimpleObject  &$obj
	 *
	 * @return  void
	**/
	public function load(/*** XoopsSimpleObject ***/ &$obj)
	{

	}

	/**
	 * update
	 *
	 * @param   XoopsSimpleObject  &$obj
	 *
	 * @return  void
	**/
	public function update(/*** XoopsSimpleObject ***/ &$obj)
	{

	}

}//END CLASS

?>