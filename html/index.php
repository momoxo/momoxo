<?php
/**
 *
 * @package Xcore
 * @version $Id: index.php,v 1.3 2008/09/25 15:10:27 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momonga-project/momonga>
 * @license https://github.com/momonga-project/momonga/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */
require_once "./mainfile.php";
require_once "./header.php";

$xoopsOption['show_cblock'] = 1;
XCube_DelegateUtils::call("Xcorepage.Top.Access");

require_once "./footer.php";
?>
