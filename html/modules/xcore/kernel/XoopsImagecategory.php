<?php

class XoopsImagecategory extends XoopsObject
{
	var $_imageCount;

	function __construct()
	{
		parent::__construct();
		$this->initVar('imgcat_id', XOBJ_DTYPE_INT, null, false);
		$this->initVar('imgcat_name', XOBJ_DTYPE_TXTBOX, null, true, 100);
		$this->initVar('imgcat_display', XOBJ_DTYPE_INT, 1, false);
		$this->initVar('imgcat_weight', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('imgcat_maxsize', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('imgcat_maxwidth', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('imgcat_maxheight', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('imgcat_type', XOBJ_DTYPE_OTHER, null, false);
		$this->initVar('imgcat_storetype', XOBJ_DTYPE_OTHER, null, false);
	}

	function setImageCount($value)
	{
		$this->_imageCount = (int)$value;
	}

	function getImageCount()
	{
		return $this->_imageCount;
	}
}
