<?php

use XCore\Form\ActionForm;
use XCore\Property\StringProperty;
use XCore\Database\Criteria;

class Xcore_TplsetSelectForm extends ActionForm
{
	function getTokenName()
	{
		return "module.xcore.TemplatesetSelectForm.TOKEN";
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['tplset_name'] =new StringProperty('tplset_name');
	}

	function validateTplset_name()
	{
		$handler =& xoops_getmodulehandler('tplset');
		if ($handler->getCount(new Criteria('tplset_name', $this->get('tplset_name'))) == 0) {
			$this->addErrorMessage(_AD_XCORE_ERROR_TPLSET_NO_EXIST);
		}
	}
}

