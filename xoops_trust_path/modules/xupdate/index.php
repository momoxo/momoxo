<?php
/**
 * @file
 * @brief The page controller in the directory
 * @package xupdate
 * @version $Id$
**/

use XCore\Kernel\Root;

$root = Root::getSingleton();

$root->mController->executeHeader();
$root->mController->execute();


$xoopsLogger=&$root->mController->getLogger();
$xoopsLogger->stopTime();
$root->mController->executeView();

?>