<?php
use XCore\Kernel\Root;

require_once '../../../mainfile.php';
$root = Root::getSingleton();
$root->mController->executeForward($root->mContext->mModule->getAdminIndex());
?>