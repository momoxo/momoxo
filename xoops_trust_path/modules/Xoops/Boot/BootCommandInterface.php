<?php

namespace Xoops\Boot;

use Xoops\Kernel\ControllerInterface;

interface BootCommandInterface
{
    /**
     * @param ControllerInterface $controller
     */
    public function setController(ControllerInterface $controller);

    /**
     * Execute this command
     * @return void
     */
    public function execute();
}
