<?php

namespace Xoops\Boot;

interface BootCommandInterface
{
    public function setRoot($root);

    public function execute();
}
