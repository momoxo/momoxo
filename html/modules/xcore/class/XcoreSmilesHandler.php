<?php

use XCore\Repository\ObjectGenericRepository;

class XcoreSmilesHandler extends ObjectGenericRepository
{
	var $mTable = "smiles";
	var $mPrimary = "id";
	var $mClass = "XcoreSmilesObject";
	
	function delete(&$obj, $force = false)
	{
		@unlink(XOOPS_UPLOAD_PATH . "/" . $obj->get('smile_url'));
		
		return parent::delete($obj);
	}
}
