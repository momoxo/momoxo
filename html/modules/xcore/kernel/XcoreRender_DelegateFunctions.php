<?php

use XCore\Kernel\Theme;

class XcoreRender_DelegateFunctions
{
	/**
	 * Search themes that Xcore_RenderSystem can render in file system.
	 */	
	public static function getInstalledThemes(&$results)
	{
		foreach (glob(XOOPS_THEME_PATH.'/*', GLOB_ONLYDIR) as $themeDir) {
			$theme =new Theme();
			$theme->mDirname = $dirname = basename($themeDir);
		
			if ($theme->loadManifesto($themeDir . '/manifesto.ini.php')) {
				if ($theme->mRenderSystemName != 'Xcore_RenderSystem') continue;
			} else {
				if (file_exists($themeDir . '/theme.html')) {
					$theme->mName = $dirname;
					$theme->mRenderSystemName = 'Xcore_RenderSystem';
					$theme->mFormat = 'XOOPS2 Legacy Style';
				}
			}
			$results[$dirname] =& $theme;
			unset($theme);
		}
	}
}
