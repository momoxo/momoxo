<?php

namespace Xoops\Tests\Unit\Delegate;

use Xoops\Tests\Unit\Delegate\DelegateInterfaceTest;
use Xoops\Delegate\DelegateInterface;
use Xoops\Delegate\Delegate;

class DelegateTest extends DelegateInterfaceTest
{
    /**
     * @return DelegateInterface
     */
    protected function getDelegate()
    {
        return new Delegate();
    }
}
