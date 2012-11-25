<?php

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

define('XCUBE_CORE_PATH', dirname(__DIR__).'/kernel');

//
// TODO We have to move the following lines to an appropriate place.
//		(We may not need the following constants)
//

define("XCUBE_SITE_SETTING_FILE", XOOPS_TRUST_PATH . "/settings/site_default.ini");
define("XCUBE_SITE_CUSTOM_FILE", XOOPS_TRUST_PATH . "/settings/site_custom.ini");
define('XCUBE_SITE_CUSTOM_FILE_SALT', XOOPS_TRUST_PATH . '/settings/site_custom_' . XOOPS_SALT . '.ini');
define("XCUBE_SITE_DIST_FILE", XOOPS_TRUST_PATH . "/settings/site_default.dist.ini"); // for CorePack

require_once XOOPS_TRUST_PATH.'/settings/definition.inc.php';


require_once XOOPS_ROOT_PATH.'/modules/xcore/class/_constants.php'; // TODO >> これがなくても動くようにする
require_once XOOPS_ROOT_PATH.'/modules/xcore/class/_functions.php'; // TODO >> これがなくても動くようにする
require_once XOOPS_ROOT_PATH.'/modules/xcore/kernel/_constants.php'; // TODO >> これがなくても動くようにする
require_once XOOPS_ROOT_PATH.'/modules/xcore/kernel/_functions.php'; // TODO >> これがなくても動くようにする
require_once XOOPS_ROOT_PATH.'/modules/xcore/include/comment_constants.php'; // TODO >> これがなくても動くようにする
require_once XOOPS_ROOT_PATH.'/modules/xcore/include/notification_constants.php'; // TODO >> これがなくても動くようにする

//
//@todo How does the system decide the main controller?
//
$root=&XCube_Root::getSingleton();
//$root->loadSiteConfig(XCUBE_SITE_SETTING_FILE, XCUBE_SITE_CUSTOM_FILE, XCUBE_SITE_CUSTOM_FILE_SALT);
$root->loadSiteConfig(XCUBE_SITE_SETTING_FILE, XCUBE_SITE_DIST_FILE, XCUBE_SITE_CUSTOM_FILE, XCUBE_SITE_CUSTOM_FILE_SALT); // edit by CorePack
$root->setupController();
