<?php

namespace Xoops\Tests\Unit\Delegate;

use Xoops\Delegate\DelegateInterface;

abstract class DelegateInterfaceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return DelegateInterface
     */
    abstract protected function getDelegate();

    final public function testAdd()
    {
        $delegate = $this->getDelegate();
        $delegate->add(
            function () {
                // do nothing
            }
        );
        $delegate->add('strtolower');
    }

    final public function testCall()
    {
        $delegate = $this->getDelegate();
        $delegate->add(
            function ($name) {
                return 'Hello '.$name;
            }
        );
        $result = $delegate->call('World');

        $this->assertSame('Hello World', $result);
    }

    final public function testPriority()
    {
        $delegate = $this->getDelegate();
        $delegate->add(
            function ($name) {
                return 'Good morning, '.$name;
            }
        );
        $delegate->add(
            function ($name) {
                return 'Good afternoon, '.$name;
            },
            1
        );
        $delegate->add(
            function ($name) {
                return 'Good night, '.$name;
            }
        );

        $result = $delegate->call('Alice');

        $this->assertSame('Good afternoon, Alice', $result);
    }

    final public function testRemove()
    {
        $callback = function () {
            return 'this should not appear';
        };

        $delegate = $this->getDelegate();
        $delegate->add($callback);
        $delegate->remove($callback);
        $result = $delegate->call();
        $this->assertNull($result);
    }

    final public function testReset()
    {
        $delegate = $this->getDelegate();
        $delegate->add(
            function () {
                return 'this should not appear';
            }
        );
        $delegate->reset();
        $this->assertNull($delegate->call());
    }
}
