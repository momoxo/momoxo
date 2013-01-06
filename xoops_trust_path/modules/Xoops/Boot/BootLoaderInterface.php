<?php

namespace Xoops\Boot;

use Xoops\Boot\BootCommandInterface;

interface BootLoaderInterface
{
    public function addCommand(BootCommandInterface $command);

    public function execute();
}
