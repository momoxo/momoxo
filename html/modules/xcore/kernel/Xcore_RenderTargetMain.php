<?php

class Xcore_RenderTargetMain extends XCube_RenderTarget
{
	function Xcore_RenderTargetMain()
	{
		parent::__construct();
		$this->setAttribute('xcore_buffertype', XCORE_RENDER_TARGET_TYPE_MAIN);
	}
}
