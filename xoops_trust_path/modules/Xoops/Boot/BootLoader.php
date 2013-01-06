<?php

namespace Xoops\Boot;

use Xoops\Boot\BootLoaderInterface;
use Xoops\Boot\BootCommandInterface;
use Xoops\Kernel\ControllerInterface;

class BootLoader implements BootLoaderInterface
{
    /**
     * @var ControllerInterface
     */
    private $controller;

    /**
     * @var BootCommandInterface[]
     */
    private $commands = array();

    /**
     * {@inherit}
     */
    public function __construct(ControllerInterface $controller)
    {
        $this->controller = $controller;
    }

    /**
     * {@inherit}
     */
    public function addCommand(BootCommandInterface $command)
    {
        $this->commands[] = $command;
    }

    /**
     * {@inherit}
     */
    public function execute()
    {
        foreach ($this->commands as $command) {
            $command->setController($this->controller);
            $command->execute();
        }
    }
}
