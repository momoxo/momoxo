<?php

class Xcore_DialogRenderTarget extends Xcore_AbstractThemeRenderTarget
{
	function __construct()
	{
		parent::__construct();
		$this->setAttribute("isFileTheme",false);
	}
	
	function getTemplateName()
	{
		return "xcore_dialog.html";
	}

}
