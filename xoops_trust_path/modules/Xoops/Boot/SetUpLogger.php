<?php

namespace Xoops\Boot;

use Xoops\Boot\BootCommandInterface;
use Xoops\Kernel\ControllerInterface;
use XCore\Kernel\Logger;

class SetUpLogger implements BootCommandInterface
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
        /** @var $logger Logger */
        $logger = Logger::instance(); // @todo just create instance
        $logger->startTime();
        $GLOBALS['xoopsLogger'] = $logger; // @todo remove this
        $this->controller->setLogger($logger);
    }
}
