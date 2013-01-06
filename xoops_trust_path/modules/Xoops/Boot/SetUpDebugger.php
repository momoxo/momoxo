<?php

namespace Xoops\Boot;

use XCore\Kernel\Ref;
use Xoops\Boot\BootCommandInterface;
use Xoops\Kernel\ControllerInterface;

/**
 * Set debugger object to member property.
 */
class SetUpDebugger implements BootCommandInterface
{
    /**
     * @var ControllerInterface
     */
    private $controller;

    /**
     * {@inherit}
     */
    public function setController(ControllerInterface $controller)
    {
        $this->controller = $controller;
    }

    /**
     * {@inherit}
     */
    public function execute()
    {
        error_reporting(0);

        $debugMode = $this->controller->getRoot()->getContext()->getXoopsConfig('debug_mode');

        if (defined('OH_MY_GOD_HELP_ME')) {
            $debugMode = XOOPS_DEBUG_PHP;
        }

        $debugger = null;

        $this->controller->getSetUpDebuggerDelegate()->call(new Ref($debugger), $debugMode);
        $debugger->prepare();

        $GLOBALS['xoopsDebugger'] = $debugger; // @todo Avoid to use global variable

        $this->controller->setDebugger($debugger);
    }
}
