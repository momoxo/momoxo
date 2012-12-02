<?php
/**
 *
 * @package Xcore
 * @version $Id: admin.php,v 1.3 2008/09/25 15:10:19 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momoxo/momoxo>
 * @license https://github.com/momoxo/momoxo/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */
/*------------------------------------------------------------------------*
 |  This file was entirely rewritten by the XOOPS Cube Legacy project for |
 |   keeping compatibility with XOOPS 2.0.x <http://www.xoops.org>        |
 *------------------------------------------------------------------------*/

use XCore\Kernel\Root;
use XCore\Kernel\DelegateUtils;

include "mainfile.php";

class DefaultSystemCheckFunction
{
	public static function DefaultCheck()
	{
		if ( ini_get('register_globals') == 1 ) {
		    xoops_error(sprintf(_WARNPHPENV,'register_globals','on',_WARNSECURITY),'','warning');
		}
	}
}

require_once XOOPS_ROOT_PATH . "/header.php";
$root = Root::getSingleton();
$root->mDelegateManager->add("Xcorepage.Admin.SystemCheck", "DefaultSystemCheckFunction::DefaultCheck");
DelegateUtils::call("Xcorepage.Admin.SystemCheck");
require_once XOOPS_ROOT_PATH . "/footer.php";
?>
