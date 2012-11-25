<?php

class Xcore_ThemeRenderTarget extends Xcore_AbstractThemeRenderTarget
{
	function Xcore_ThemeRenderTarget()
	{
		parent::Xcore_AbstractThemeRenderTarget();
		$this->setAttribute("isFileTheme",true);
	}
}
