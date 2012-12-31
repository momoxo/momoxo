<?php

use XCore\Repository\ObjectGenericRepository;
use XCore\Database\Criteria;

class XcoreTplsetHandler extends ObjectGenericRepository
{
	var $mTable = "tplset";
	var $mPrimary = "tplset_id";
	var $mClass = "XcoreTplsetObject";
	
	function insertClone($original, $clone)
	{
		if (!$this->insert($clone)) {
			return false;
		}
		
		//
		// fetch all tplfile object and do cloning.
		//
		$handler =& xoops_getmodulehandler('tplfile', 'xcore');
		
		$files =& $handler->getObjects(new Criteria('tpl_tplset', $original->get('tplset_name')));
		foreach ($files as $file) {
			$cloneFile =& $file->createClone($clone->get('tplset_name'));
			$handler->insert($cloneFile);
		}
		
		return true;	///< TODO
	}

	function delete(&$obj, $force)
	{
		$handler =& xoops_getmodulehandler('tplfile', 'xcore');
		$handler->deleteAll(new Criteria('tpl_tplset', $obj->get('tplset_name')));

		return parent::delete($obj, $force);
	}
}
