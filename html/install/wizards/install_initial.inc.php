<?php
/**
 *
 * @package Xcore
 * @version $Id: install_initial.inc.php,v 1.3 2008/09/25 15:12:17 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momonga-project/momonga>
 * @license https://github.com/momonga-project/momonga/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */
    // confirm database setting
    include_once "../mainfile.php";
    $wizard->render('install_initial.tpl.php');
?>
