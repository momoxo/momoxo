<?php

require_once XOOPS_ROOT_PATH.'/modules/xcoreRender/kernel/Xcore_AdminRenderSystem.class.php' ;
require_once XOOPS_TRUST_PATH.'/modules/altsys/include/altsys_functions.php' ;
require_once XOOPS_TRUST_PATH.'/modules/altsys/include/admin_in_theme_functions.php' ;

class Xcore_AltsysAdminRenderSystem extends Xcore_AdminRenderSystem
{
	function renderTheme(&$target)
	{
		global $altsysModuleConfig ;
	
		if( empty( $altsysModuleConfig['admin_in_theme'] ) ) {
			parent::renderTheme($target) ;
		} else {
			$attributes = $target->getAttributes() ;
			altsys_admin_in_theme_in_last( $attributes['xoops_contents'] ) ;
			exit ;
		}
	}
}

?>