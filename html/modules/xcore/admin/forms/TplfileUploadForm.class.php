<?php

class Xcore_TplfileUploadForm extends XCube_ActionForm
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
		$this->mFormProperties['upload'] =new XCube_FileArrayProperty('upload');
	
		//
		// Set field properties
		//
	}
}
