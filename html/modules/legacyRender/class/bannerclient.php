<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

class XcoreRenderBannerclientObject extends XoopsSimpleObject
{
	var $mBanners = array();
	var $_mBannersLoadedFlag = false;
	
	/**
	 * @todo A name of this property is a strange. banner finish?
	 */
	var $mFinishBanners = array();
	var $_mFinishBannersLoadedFlag = false;
	
	var $mBannerCount = null;
	var $_mBannerCountLoadedFlag = false;

	var $mFinishBannerCount = null;
	var $_mFinishBannerCountLoadedFlag = false;

	function XcoreRenderBannerclientObject()
	{
		static $initVars;
		if (isset($initVars)) {
			$this->mVars = $initVars;
			return;
		}
		$this->initVar('cid', XOBJ_DTYPE_INT, '', false);
		$this->initVar('name', XOBJ_DTYPE_STRING, '', true, 60);
		$this->initVar('contact', XOBJ_DTYPE_STRING, '', true, 60);
		$this->initVar('email', XOBJ_DTYPE_STRING, '', true, 60);
		$this->initVar('login', XOBJ_DTYPE_STRING, '', true, 10);
		$this->initVar('passwd', XOBJ_DTYPE_STRING, '', true, 10);
		$this->initVar('extrainfo', XOBJ_DTYPE_TEXT, '', true);
		$initVars=$this->mVars;
	}

	function loadBanner()
	{
		if ($this->_mBannersLoadedFlag == false) {
			$handler =& xoops_getmodulehandler('banner', 'xcoreRender');
			$this->mBanners =& $handler->getObjects(new Criteria('cid', $this->get('cid')));
			$this->_mBannersLoadedFlag = true;
		}
	}

	function loadBannerCount()
	{
		if ($this->_mBannerCountLoadedFlag == false) {
			$handler =& xoops_getmodulehandler('banner', 'xcoreRender');
			$this->mBannerCount = $handler->getCount(new Criteria('cid', $this->get('cid')));
			$this->_mBannerCountLoadedFlag = true;
		}
	}

	function &createBanner()
	{
		$handler =& xoops_getmodulehandler('banner', 'xcoreRender');
		$obj =& $handler->create();
		$obj->set('cid', $this->get('cid'));
		return $obj;
	}

	function loadBannerfinish()
	{
		if ($this->_mFinishBannersLoadedFlag == false) {
			$handler =& xoops_getmodulehandler('bannerfinish', 'xcoreRender');
			$this->mFinishBanners =& $handler->getObjects(new Criteria('cid', $this->get('cid')));
			$this->_mFinishBannersLoadedFlag = true;
		}
	}

	function loadFinishBannerCount()
	{
		if ($this->_mFinishBannerCountLoadedFlag == false) {
			$handler =& xoops_getmodulehandler('bannerfinish', 'xcoreRender');
			$this->mFinishBannerCount = $handler->getCount(new Criteria('cid', $this->get('cid')));
			$this->_mFinishBannerCountLoadedFlag = true;
		}
	}

	function &createBannerfinish()
	{
		$handler =& xoops_getmodulehandler('bannerfinish', 'xcoreRender');
		$obj =& $handler->create();
		$obj->set('cid', $this->get('cid'));
		return $obj;
	}
}

class XcoreRenderBannerclientHandler extends XoopsObjectGenericHandler
{
	var $mTable = "bannerclient";
	var $mPrimary = "cid";
	var $mClass = "XcoreRenderBannerclientObject";

	function delete(&$obj)
	{
		$handler =& xoops_getmodulehandler('banner', 'xcoreRender');
		$handler->deleteAll(new Criteria('cid', $obj->get('cid')));
		unset($handler);
	
		$handler =& xoops_getmodulehandler('bannerfinish', 'xcoreRender');
		$handler->deleteAll(new Criteria('cid', $obj->get('cid')));
		unset($handler);
	
		return parent::delete($obj);
	}
}

?>
