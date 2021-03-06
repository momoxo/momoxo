<?php

class XcoreImageObject extends XoopsSimpleObject
{
	var $mImageCategory = null;
	var $_mImageCategoryLoadedFlag = false;
	var $mImageBody = null;
	var $_mImageBodyLoadedFlag = false;

	function XcoreImageObject()
	{
		static $initVars;
		if (isset($initVars)) {
			$this->mVars = $initVars;
			return;
		}
		$this->initVar('image_id', XOBJ_DTYPE_INT, '', false);
		$this->initVar('image_name', XOBJ_DTYPE_STRING, '', true, 30);
		$this->initVar('image_nicename', XOBJ_DTYPE_STRING, '', true, 255);
		$this->initVar('image_mimetype', XOBJ_DTYPE_STRING, '', true, 30);
		$this->initVar('image_created', XOBJ_DTYPE_INT, time(), true);
		$this->initVar('image_display', XOBJ_DTYPE_BOOL, '1', true);
		$this->initVar('image_weight', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('imgcat_id', XOBJ_DTYPE_INT, '0', true);
		$initVars=$this->mVars;
	}

	function loadImagecategory()
	{
		if ($this->_mImageCategoryLoadedFlag == false) {
			$handler =& xoops_getmodulehandler('imagecategory', 'xcore');
			$this->mImageCategory =& $handler->get($this->get('imgcat_id'));
			$this->_mImageCategoryLoadedFlag = true;
		}
	}

	function loadImagebody()
	{
		if ($this->_mImageBodyLoadedFlag == false) {
			$handler =& xoops_getmodulehandler('imagebody', 'xcore');
			$this->mImageBody =& $handler->get($this->get('image_id'));
			$this->_mImageBodyLoadedFlag = true;
		}
	}

	function &createImagebody()
	{
		$handler =& xoops_getmodulehandler('imagebody', 'xcore');
		$obj =& $handler->create();
		$obj->set('image_id', $this->get('image_id'));
		return $obj;
	}
}
