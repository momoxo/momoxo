<?php

class Xcore_ThemeRenderTarget extends Xcore_AbstractThemeRenderTarget
{
	function __construct()
	{
		parent::__construct();
		$this->setAttribute("isFileTheme",true);
	}
}
