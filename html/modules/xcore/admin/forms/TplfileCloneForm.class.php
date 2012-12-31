<?php

use XCore\Form\FieldProperty;
use XCore\Property\StringProperty;
use XCore\Database\Criteria;

class Xcore_TplfileCloneForm extends Xcore_TplfileEditForm
{
	function getTokenName()
	{
		return "module.xcore.TplfileCloneForm.TOKEN";
	}

	function prepare()
	{
		parent::prepare();
		
		//
		// Set form properties
		//
		$this->mFormProperties['tpl_tplset'] =new StringProperty('tpl_tplset');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['tpl_tplset'] =new FieldProperty($this);
		$this->mFieldProperties['tpl_tplset']->setDependsByArray(array('required'));
		$this->mFieldProperties['tpl_tplset']->addMessage('required', _AD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_TPL_TPLSET);
	}
	
	function validateTpl_tplset()
	{
		$tplset = $this->get('tpl_tplset');

		$handler =& xoops_getmodulehandler('tplset', 'xcore');
		$criteria =new Criteria('tplset_name', $this->get('tpl_tplset'));
		$objs =& $handler->getObjects($criteria);
		
		if (count($objs) == 0) {
			$this->addErrorMessage(_AD_XCORE_ERROR_TPLSET_WRONG);
		}
	}
	
	function load(&$obj)
	{
		parent::load($obj);
		$this->set('tpl_tplset', $obj->get('tpl_tplset'));
	}

	function update(&$obj)
	{
		$obj->loadSource();

		$obj->set('tpl_desc', $this->get('tpl_desc'));
		$obj->set('tpl_lastmodified', time());

		$obj->Source->set('tpl_source', $this->get('tpl_source'));
	}
}

