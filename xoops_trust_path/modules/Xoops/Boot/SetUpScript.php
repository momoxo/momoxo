<?php

namespace Xoops\Boot;

use Xcore_HeaderScript;
use Xoops\Boot\BootCommandInterface;
use Xoops\Kernel\ControllerInterface;

class SetUpScript implements BootCommandInterface
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
        $headerScript = new Xcore_HeaderScript();
        $this->controller->getRoot()->getContext()->setAttribute('headerScript', $headerScript);
    }
}
