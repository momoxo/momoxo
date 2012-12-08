<?php

use XCore\Form\ActionForm;
use XCore\Property\FileArrayProperty;

class Xcore_TplfileUploadForm extends ActionForm
{
	function getTokenName()
	{
		return "module.xcore.TplfileUploadForm.TOKEN";
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['upload'] =new FileArrayProperty('upload');
	
		//
		// Set field properties
		//
	}
}
