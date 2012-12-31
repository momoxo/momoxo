<?php

use XCore\Kernel\RenderTarget;

class Xcore_RenderTargetMain extends RenderTarget
{
	function __construct()
	{
		parent::__construct();
		$this->setAttribute('xcore_buffertype', XCORE_RENDER_TARGET_TYPE_MAIN);
	}
}
