<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

class XcoreRenderBannerfinishObject extends XoopsSimpleObject
{
	var $mClient = null;
	var $_mClientLoadedFlag = false;

	function XcoreRenderBannerfinishObject()
	{
		$this->initVar('bid', XOBJ_DTYPE_INT, '', false);
		$this->initVar('cid', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('impressions', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('clicks', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('datestart', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('dateend', XOBJ_DTYPE_INT, '0', true);
	}

	function loadBannerclient()
	{
		if ($this->_mClientLoadedFlag == false) {
			$handler =& xoops_getmodulehandler('bannerclient', 'xcoreRender');
			$this->mClient =& $handler->get($this->get('cid'));
			$this->_mClientLoadedFlag = true;
		}
	}
}

class XcoreRenderBannerfinishHandler extends XoopsObjectGenericHandler
{
	var $mTable = "bannerfinish";
	var $mPrimary = "bid";
	var $mClass = "XcoreRenderBannerfinishObject";
}

?>
