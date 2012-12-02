<?php
/**
 *
 * @package Xcore
 * @version $Id: readpmsg.php,v 1.3 2008/09/25 15:10:28 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momoxo/momoxo>
 * @license https://github.com/momoxo/momoxo/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */
/*------------------------------------------------------------------------*
 |  This file was entirely rewritten by the XOOPS Cube Legacy project for |
 |   keeping compatibility with XOOPS 2.0.x <http://www.xoops.org>        |
 *------------------------------------------------------------------------*/

use XCore\Kernel\DelegateUtils;

require_once "mainfile.php";

DelegateUtils::call("Xcorepage.Readpmsg.Access");
?>
