<?php

class Xcore_AbstractThemeRenderTarget extends XCube_RenderTarget
{
	var $mSendHeaderFlag=false;

	function Xcore_AbstractThemeRenderTarget()
	{
		parent::XCube_RenderTarget();
		$this->setAttribute('xcore_buffertype', XCORE_RENDER_TARGET_TYPE_THEME);
	}

	function sendHeader()
	{
		header('Content-Type:text/html; charset='._CHARSET);
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');
	}

	function setResult(&$result)
	{
		parent::setResult($result);
		if(!$this->mSendHeaderFlag) {
			$this->sendHeader();
			$this->mSendHeaderFlag=true;
		}

		print $result;
	}
}
