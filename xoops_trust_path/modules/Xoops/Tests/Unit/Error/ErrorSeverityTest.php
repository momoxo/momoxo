<?php

namespace Xoops\Tests\Unit\Error;

use Xoops\Error\ErrorSeverity;

class ErrorSeverityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $severity
     * @param $expected
     * @dataProvider dataForTestToString
     */
    public function testToString($severity, $expected)
    {
        $this->assertSame($expected, ErrorSeverity::toString($severity));
    }

    public static function dataForTestToString()
    {
        return array(
            array(E_ERROR, 'ERROR'),
            array(E_WARNING, 'WARNING'),
            array(E_PARSE, 'PARSING ERROR'),
            array(E_NOTICE, 'NOTICE'),
            array(E_CORE_ERROR, 'CORE ERROR'),
            array(E_CORE_WARNING, 'CORE WARNING'),
            array(E_COMPILE_ERROR, 'COMPILE ERROR'),
            array(E_COMPILE_WARNING, 'COMPILE WARNING'),
            array(E_USER_ERROR, 'USER ERROR'),
            array(E_USER_WARNING, 'USER WARNING'),
            array(E_USER_NOTICE, 'USER NOTICE'),
            array(E_STRICT, 'STRICT NOTICE'),
            array(E_RECOVERABLE_ERROR, 'RECOVERABLE ERROR'),
            array(E_DEPRECATED, 'DEPRECATED'),
            array(E_USER_DEPRECATED, 'USER DEPRECATED'),
            array(-1, 'UNKNOWN ERROR'),
        );
    }
}
