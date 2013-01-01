<?php

namespace XCore\Tests\Unit\Kernel;

use XCore\Kernel\HttpContext;

class HttpContextTest extends \PHPUnit_Framework_TestCase
{
    public function testAttributes()
    {
        $context = new HttpContext();
        $this->assertNull($context->getAttribute('undefined-attribute'));

        $context->setAttribute('DUMMY_KEY', 'DUMMY_VALUE');
        $this->assertTrue($context->hasAttribute('DUMMY_KEY'));
        $this->assertSame('DUMMY_VALUE', $context->getAttribute('DUMMY_KEY'));
    }
}
