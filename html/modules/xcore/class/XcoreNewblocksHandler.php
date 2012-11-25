<?php

class XcoreNewblocksHandler extends XoopsObjectGenericHandler
{
	var $mTable = "newblocks";
	var $mPrimary = "bid";
	var $mClass = "XcoreNewblocksObject";
	
	function delete(&$obj, $force = false)
	{
		if (parent::delete($obj, $force)) {
			//
			// Delete related data from block_module_link.
			//
			$handler =& xoops_getmodulehandler('block_module_link', 'xcore');
			$handler->deleteAll(new Criteria('block_id'), $obj->get('bid'));
			
			//
			// Delete related permissions from groupperm.
			//
			$handler =& xoops_gethandler('groupperm');

			$criteria =new CriteriaCompo();
			$criteria->add(new Criteria('gperm_modid', 1));
			$criteria->add(new Criteria('gperm_itemid', $obj->get('bid')));
			$criteria->add(new Criteria('gperm_name', 'block_read'));
			
			$handler->deleteAll($criteria);
			
			return true;
		}
		else {
			return false;
		}
	}
}
