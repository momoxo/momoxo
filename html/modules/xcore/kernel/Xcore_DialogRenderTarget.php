<?php

class Xcore_DialogRenderTarget extends Xcore_AbstractThemeRenderTarget
{
	function Xcore_DialogRenderTarget()
	{
		parent::Xcore_AbstractThemeRenderTarget();
		$this->setAttribute("isFileTheme",false);
	}
	
	function getTemplateName()
	{
		return "xcore_dialog.html";
	}

}
