<?php 
/**
 *
 * @package Xcore
 * @version $Id: cp_header.php,v 1.3 2008/09/25 15:12:45 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momonga-project/momonga>
 * @license https://github.com/momonga-project/momonga/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */
/*------------------------------------------------------------------------*
 |  This file was entirely rewritten by the XOOPS Cube Legacy project for |
 |   keeping compatibility with XOOPS 2.0.x <http://www.xoops.org>        |
 *------------------------------------------------------------------------*/

if (!defined('XOOPS_CPFUNC_LOADED')) require_once XOOPS_ROOT_PATH . "/modules/xcore/include/cp_functions.php";

//
// [Special Mission] Additional CHECK!!
// Old modules may call this file from other admin directory.
// In this case, the controller does not have Admin Module Object.
//
$root =& XCube_Root::getSingleton();

require_once XOOPS_ROOT_PATH . "/modules/xcore/kernel/Xcore_AdminControllerStrategy.class.php";
$strategy =new Xcore_AdminControllerStrategy($root->mController);

$root->mController->setStrategy($strategy);
$root->mController->setupModuleContext();
$root->mController->_mStrategy->setupModuleLanguage();	//< Umm...

//
// TODO
//

