<?php

namespace Xoops\Kernel;

interface ActionFilterInterface
{
    /**
     * @return void
     */
    public function preFilter();

    /**
     * @return void
     */
    public function preBlockFilter();

    /**
     * @return void
     */
    public function postFilter();
}
