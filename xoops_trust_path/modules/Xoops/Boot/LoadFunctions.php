<?php

namespace Xoops\Boot;

use Xoops\Boot\BootCommandInterface;
use Xoops\Kernel\ControllerInterface;

class LoadFunctions implements BootCommandInterface
{
    /**
     * {@inherit}
     */
    public function setController(ControllerInterface $controller)
    {
        // This command does not require Controller object
    }

    /**
     * {@inherit}
     */
    public function execute()
    {
        require_once XOOPS_ROOT_PATH.'/modules/xcore/include/version.php';

        define('XOOPS_XCORE_PATH', XOOPS_MODULE_PATH.'/'.XOOPS_XCORE_PROC_NAME);

        require_once XOOPS_ROOT_PATH.'/modules/xcore/include/functions.php';
    }
}
