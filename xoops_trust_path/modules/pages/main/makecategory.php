<?php

require_once dirname(dirname(__FILE__)).'/include/main_functions.php' ;
require_once dirname(dirname(__FILE__)).'/include/common_functions.php' ;
require_once dirname(dirname(__FILE__)).'/class/pages.textsanitizer.php' ;
require_once dirname(dirname(__FILE__)).'/class/PagesUriMapper.class.php' ;
require_once dirname(dirname(__FILE__)).'/class/PagesPermission.class.php' ;
require_once dirname(dirname(__FILE__)).'/class/PagesModelCategory.class.php' ;
require_once dirname(dirname(__FILE__)).'/class/PagesModelContent.class.php' ;
require_once XOOPS_TRUST_PATH.'/modules/altsys/class/AltsysBreadcrumbs.class.php' ;

// breadcrumbs
$breadcrumbsObj = AltsysBreadcrumbs::getInstance() ;
$breadcrumbsObj->appendPath( XOOPS_URL.'/modules/'.$mydirname.'/index.php' , $xoopsModule->getVar( 'name' ) ) ;

// permissions
$pagesPermission = PagesPermission::getInstance() ;
$permissions = $pagesPermission->getPermissions( $mydirname ) ;

// current category object (this "current" means "parent"
$currentCategoryObj = new PagesCategory( $mydirname , intval( @$_REQUEST['pid'] ) , $permissions ) ;
if( $currentCategoryObj->isError() ) {
	redirect_header( XOOPS_URL."/modules/$mydirname/index.php" , 2 , _MD_PAGES_ERR_READCATEGORY ) ;
	exit ;
}

// override $xoopsModuleConfig
$xoopsModuleConfig = $currentCategoryObj->getOverriddenModConfig() ;

// append paths from each categories into breadcrumbs
$breadcrumbsObj->appendPath( $currentCategoryObj->getBreadcrumbs() ) ;

// request
$pagesRequest = array() ;
$pagesRequest['makecategory'] = true ;
$pagesRequest['cat_id'] = -1 ;

if( ! empty( $_POST['categoryman_post'] ) ) {
	$controller_class = 'PagesControllerInsertCategory' ;
} else {
	$controller_class = 'PagesControllerEditCategory' ;
}

require_once dirname(dirname(__FILE__)).'/class/'.$controller_class.'.class.php' ;
$controller = new $controller_class( $currentCategoryObj ) ;
$controller->execute( $pagesRequest ) ;

// render
if( $controller->isNeedHeaderFooter() ) {
	$xoopsOption['template_main'] = $controller->getTemplateName() ;
	include XOOPS_ROOT_PATH.'/header.php';
	$xoopsTpl->assign( $controller->getAssign() ) ;
	$xoopsTpl->assign( 'xoops_module_header' , pages_main_render_moduleheader( $mydirname , $xoopsModuleConfig , $controller->getHtmlHeader() ) . $xoopsTpl->get_template_vars( 'xoops_module_header' ) ) ;
	include XOOPS_ROOT_PATH.'/footer.php';
} else {
	$controller->render() ;
}
exit ;

?>
