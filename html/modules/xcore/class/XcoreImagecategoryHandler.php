<?php

use XCore\Repository\ObjectGenericRepository;
use XCore\Database\CriteriaCompo;
use XCore\Database\Criteria;

class XcoreImagecategoryHandler extends ObjectGenericRepository
{
	var $mTable = "imagecategory";
	var $mPrimary = "imgcat_id";
	var $mClass = "XcoreImagecategoryObject";

	function insert(&$obj, $force = false)
	{
		$returnFlag = parent::insert($obj, $force);
		
		$handler =& xoops_getmodulehandler('group_permission', 'xcore');
		
		//
		// If the object has groups which are allowed to read.
		//
		if ($obj->isLoadedReadGroups()) {
			$criteria =new CriteriaCompo();
			$criteria->add(new Criteria('gperm_itemid', $obj->get('imgcat_id')));
			$criteria->add(new Criteria('gperm_modid', 1));
			$criteria->add(new Criteria('gperm_name', 'imgcat_read'));
			$handler->deleteAll($criteria);
			
			foreach ($obj->mReadGroups as $group) {
				$perm =& $handler->create();
				$perm->set('gperm_groupid', $group->get('groupid'));
				$perm->set('gperm_itemid', $obj->get('imgcat_id'));
				$perm->set('gperm_modid', 1);
				$perm->set('gperm_name', 'imgcat_read');
				
				$returnFlag &= $handler->insert($perm, $force);
			}
		}

		//
		// If the object has groups which are allowed to upload.
		//
		if ($obj->isLoadedUploadGroups()) {
			$criteria =new CriteriaCompo();
			$criteria->add(new Criteria('gperm_itemid', $obj->get('imgcat_id')));
			$criteria->add(new Criteria('gperm_modid', 1));
			$criteria->add(new Criteria('gperm_name', 'imgcat_write'));
			$handler->deleteAll($criteria);
			
			foreach ($obj->mUploadGroups as $group) {
				$perm =& $handler->create();
				$perm->set('gperm_groupid', $group->get('groupid'));
				$perm->set('gperm_itemid', $obj->get('imgcat_id'));
				$perm->set('gperm_modid', 1);
				$perm->set('gperm_name', 'imgcat_write');
				
				$returnFlag &= $handler->insert($perm, $force);
			}
		}
		
		return $returnFlag;
	}
	
	function &getObjectsWithReadPerm($groups = array(), $display = null)
	{
		$criteria = new CriteriaCompo();
		if ($display != null) {
			$criteria->add(new Criteria('imgcat_display', $display));
		}
		$criteria->setSort('imgcat_weight');
		$objs =& $this->getObjects($criteria);
		unset($criteria);

		$ret = array();
		foreach (array_keys($objs) as $key) {
			if ($objs[$key]->hasReadPerm($groups)) {
				$ret[] =& $objs[$key];
			}
		}
		
		return $ret;
	}

	function delete(&$obj, $force = false)
	{
		$handler =& xoops_getmodulehandler('image', 'xcore');
		$handler->deleteAll(new Criteria('imgcat_id', $obj->get('imgcat_id')));
		unset($handler);
	
		$handler =& xoops_getmodulehandler('group_permission', 'xcore');
		$criteria =new CriteriaCompo();
		$criteria->add(new Criteria('gperm_itemid', $obj->get('imgcat_id')));
		$criteria->add(new Criteria('gperm_modid', 1));
		
		$nameCriteria =new CriteriaCompo();
		$nameCriteria->add(new Criteria('gperm_name', 'imgcat_read'));
		$nameCriteria->add(new Criteria('gperm_name', 'imgcat_write'), 'OR');
		
		$criteria->add($nameCriteria);
		
		$handler->deleteAll($criteria);

		return parent::delete($obj, $force);
	}
}
