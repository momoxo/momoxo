<?php
/**
 * @file
 * @brief The page controller in the directory
 * @package profile
 * @version $Id$
 */

use XCore\Kernel\Root;

require_once "../../mainfile.php";
require_once XOOPS_ROOT_PATH . "/header.php";

$root =& Root::getSingleton();

$root->mController->execute();

require_once XOOPS_ROOT_PATH . "/footer.php";

?>
