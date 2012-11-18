<?php
/**
 *
 * @package Xcore
 * @version $Id: cubecore_init.php,v 1.3 2008/09/25 15:12:45 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momonga-project/momonga>
 * @license https://github.com/momonga-project/momonga/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined("XOOPS_MAINFILE_INCLUDED")) exit();
if (!defined('XOOPS_TRUST_PATH')){
	echo "XOOPS_TRUST_PATH is required after XOOPS Cube Legacy 2.2 in mainfile.php";exit();
}


/**
 * This constant is the sign which this system is XOOPS Cube, for module
 * developers.
 */
define('XOOPS_CUBE_XCORE', true);

/**
 * This constant is the sign which this system is XOOPS Cube, for module
 * developers.
 * ex) if(defined('XCORE_BASE_VERSION') && version_compare(XCORE_BASE_VERSION, '2.2.0.0', '>='))
 */
define('XCORE_BASE_VERSION', '2.2.2.0');

require_once XOOPS_ROOT_PATH . "/modules/xcore/kernel/XCube_Root.class.php";
require_once XOOPS_ROOT_PATH . "/modules/xcore/kernel/XCube_Controller.class.php";
require_once XOOPS_ROOT_PATH . "/modules/xcore/kernel/libs/IniHandler.class.php";

//
// TODO We have to move the following lines to an appropriate place.
//		(We may not need the following constants)
//

define("XCUBE_SITE_SETTING_FILE", XOOPS_TRUST_PATH . "/settings/site_default.ini");
define("XCUBE_SITE_CUSTOM_FILE", XOOPS_TRUST_PATH . "/settings/site_custom.ini");
define('XCUBE_SITE_CUSTOM_FILE_SALT', XOOPS_TRUST_PATH . '/settings/site_custom_' . XOOPS_SALT . '.ini');
define("XCUBE_SITE_DIST_FILE", XOOPS_TRUST_PATH . "/settings/site_default.dist.ini"); // for CorePack

//
//@todo How does the system decide the main controller?
//
$root=&XCube_Root::getSingleton();
//$root->loadSiteConfig(XCUBE_SITE_SETTING_FILE, XCUBE_SITE_CUSTOM_FILE, XCUBE_SITE_CUSTOM_FILE_SALT);
$root->loadSiteConfig(XCUBE_SITE_SETTING_FILE, XCUBE_SITE_DIST_FILE, XCUBE_SITE_CUSTOM_FILE, XCUBE_SITE_CUSTOM_FILE_SALT); // edit by CorePack
$root->setupController();

?>