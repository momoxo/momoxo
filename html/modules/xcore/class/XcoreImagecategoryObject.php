<?php

class XcoreImagecategoryObject extends XoopsSimpleObject
{
	var $mImage = array();
	var $_mImageLoadedFlag = false;

	/**
	 * Array of group objects which are allowed to read files of this category.
	 */	
	var $mReadGroups = array();
	var $_mReadGroupsLoadedFlag = false;

	/**
	 * Array of group objects which are allowed to upload a file to this category.
	 */	
	var $mUploadGroups = array();
	var $_mUploadGroupsLoadedFlag = false;
	

	function XcoreImagecategoryObject()
	{
		static $initVars;
		if (isset($initVars)) {
			$this->mVars = $initVars;
			return;
		}
		$this->initVar('imgcat_id', XOBJ_DTYPE_INT, '', false);
		$this->initVar('imgcat_name', XOBJ_DTYPE_STRING, '', true, 100);
		$this->initVar('imgcat_maxsize', XOBJ_DTYPE_INT, '50000', true);
		$this->initVar('imgcat_maxwidth', XOBJ_DTYPE_INT, '120', true);
		$this->initVar('imgcat_maxheight', XOBJ_DTYPE_INT, '120', true);
		$this->initVar('imgcat_display', XOBJ_DTYPE_BOOL, '1', true);
		$this->initVar('imgcat_weight', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('imgcat_type', XOBJ_DTYPE_STRING, 'C', true, 1);
		$this->initVar('imgcat_storetype', XOBJ_DTYPE_STRING, 'file', true, 5);
		$initVars=$this->mVars;
	}

	function loadImage()
	{
		if ($this->_mImageLoadedFlag == false) {
			$handler =& xoops_getmodulehandler('image', 'xcore');
			$this->mImage =& $handler->getObjects(new Criteria('imagecat_id', $this->get('imagecat_id')));
			$this->_mImageLoadedFlag = true;
		}
	}

	function &createImage()
	{
		$handler =& xoops_getmodulehandler('image', 'xcore');
		$obj =& $handler->create();
		$obj->set('imagecat_id', $this->get('imagecat_id'));
		return $obj;
	}
	
	function getImageCount()
	{
		$handler =& xoops_getmodulehandler('image', 'xcore');
		return $handler->getCount(new Criteria('imgcat_id', $this->get('imgcat_id')));
	}
	
	function loadReadGroups()
	{
		if ($this->_mReadGroupsLoadedFlag) {
			return;
		}
		
		$handler =& xoops_gethandler('groupperm');
		$gidArr = $handler->getGroupIds('imgcat_read', $this->get('imgcat_id'));
		
		$handler =& xoops_gethandler('group');
		foreach ($gidArr as $gid) {
			$object =& $handler->get($gid);
			
			if (is_object($object)) {
				$this->mReadGroups[] =& $object;
			}
			
			unset($object);
		}
		
		$this->_mReadGroupsLoadedFlag = true;
	}
	
	function isLoadedReadGroups()
	{
		return $this->_mReadGroupsLoadedFlag;
	}

	/**
	 * If $groups has the permission of reading this object, return true.
	 */	
	function hasReadPerm($groups)
	{
		$this->loadReadGroups();
		foreach (array_keys($this->mReadGroups) as $key) {
			foreach ($groups as $group) {
				if ($this->mReadGroups[$key]->get('groupid') == $group) {
					return true;
				}
			}
		}
		
		return false;
	}

	function loadUploadGroups()
	{
		if ($this->_mUploadGroupsLoadedFlag) {
			return;
		}
		
		$handler =& xoops_gethandler('groupperm');
		$gidArr = $handler->getGroupIds('imgcat_write', $this->get('imgcat_id'));
		
		$handler =& xoops_gethandler('group');
		foreach ($gidArr as $gid) {
			$object =& $handler->get($gid);
			
			if (is_object($object)) {
				$this->mUploadGroups[] =& $object;
			}
			
			unset($object);
		}
		
		$this->_mUploadGroupsLoadedFlag = true;
	}
	
	function isLoadedUploadGroups()
	{
		return $this->_mUploadGroupsLoadedFlag;
	}

	function hasUploadPerm($groups)
	{
		$this->loadUploadGroups();
		foreach (array_keys($this->mUploadGroups) as $key) {
			foreach ($groups as $group) {
				if ($this->mUploadGroups[$key]->get('groupid') == $group) {
					return true;
				}
			}
		}
		
		return false;
	}
}
