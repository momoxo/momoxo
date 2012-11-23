<?php
/**
 *
 * @package Xcore
 * @version $Id: xcore_waiting.php,v 1.3 2008/09/25 15:12:12 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momoxo/momoxo>
 * @license https://github.com/momoxo/momoxo/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */
/*------------------------------------------------------------------------*
 |  This file was entirely rewritten by the XOOPS Cube Legacy project for |
 |   keeping compatibility with XOOPS 2.0.x <http://www.xoops.org>        |
 *------------------------------------------------------------------------*/

function b_xcore_waiting_show() {
    $modules = array();
    XCube_DelegateUtils::call('Xcoreblock.Waiting.Show', new XCube_Ref($modules));
    $block['modules'] = $modules;
    return $block;
}
