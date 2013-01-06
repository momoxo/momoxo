<?php

namespace Xoops\Boot;

use Xoops\Kernel\ControllerInterface;
use Xoops\Boot\BootCommandInterface;

interface BootLoaderInterface
{
    /**
     * Return new BootLoader object
     * @param ControllerInterface $controller
     */
    public function __construct(ControllerInterface $controller);

    /**
     * Add a BootCommand object
     * @param BootCommandInterface $command
     * @return void
     */
    public function addCommand(BootCommandInterface $command);

    /**
     * Run all boot commands
     * @return void
     */
    public function execute();
}
