<?php

/*------------------------------------------------------------------------*
 |  This file was entirely rewritten by the XOOPS Cube Legacy project for |
 |   keeping compatibility with XOOPS 2.0.x <http://www.xoops.org>        |
 *------------------------------------------------------------------------*/

require_once XOOPS_ROOT_PATH . '/modules/xcore/include/cubecore_init.php';

$root=&XCube_Root::getSingleton();
$xoopsController=&$root->getController();
$xoopsController->executeCommon();

