<?php

namespace Xoops\Tests\Unit\Experimental;

use Xoops\Experimental\UrlParser;

class UrlParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $xoopsUrl
     * @param $server
     * @param $expected
     * @dataProvider dataForTestParse
     */
    public function testParse($xoopsUrl, $server, $expected)
    {
        foreach ($server as $key => $value) {
            $_SERVER[$key] = $value;
        }

        $this->assertSame($expected, UrlParser::parse($xoopsUrl));
    }

    public static function dataForTestParse()
    {
        return array(
            // without path, without PATH_INFO
            array(
                'http://example.com',
                array(
                    'PATH_INFO'   => '',
                    'PHP_SELF'    => '/index.php',
                    'SCRIPT_NAME' => '/index.php',
                ),
                array('index.php'),
            ),
            // without path, with PATH_INFO
            array(
                'http://example.com',
                array(
                    'PATH_INFO'   => '/foo/bar',
                    'PHP_SELF'    => '/index.php/foo/bar',
                    'SCRIPT_NAME' => '/index.php',
                ),
                array('index.php'),
            ),
            // with path, without PATH_INFO
            array(
                'http://example.com/xoops/html',
                array(
                    'PATH_INFO'   => '',
                    'PHP_SELF'    => '/xoops/html/index.php',
                    'SCRIPT_NAME' => '/xoops/html/index.php',
                ),
                array('index.php'),
            ),
            // with path, with PATH_INFO
            array(
                'http://example.com/xoops/html',
                array(
                    'PATH_INFO'   => '/foo/bar',
                    'PHP_SELF'    => '/xoops/html/index.php/foo/bar',
                    'SCRIPT_NAME' => '/xoops/html/index.php',
                ),
                array('index.php'),
            ),
            // module index
            array(
                'http://example.com/xoops/html',
                array(
                    'PATH_INFO'   => '',
                    'PHP_SELF'    => '/xoops/html/modules/news/index.php',
                    'SCRIPT_NAME' => '/xoops/html/modules/news/index.php',
                ),
                array('modules', 'news', 'index.php'),
            ),
            // module admin index
            array(
                'http://example.com/xoops/html',
                array(
                    'PATH_INFO'   => '',
                    'PHP_SELF'    => '/xoops/html/modules/news/admin/index.php',
                    'SCRIPT_NAME' => '/xoops/html/modules/news/admin/index.php',
                ),
                array('modules', 'news', 'admin', 'index.php'),
            ),
            // slashes
            array(
                'http://example.com',
                array(
                    'PATH_INFO'   => '',
                    'PHP_SELF'    => '/modules/user//admin///index.php',
                    'SCRIPT_NAME' => '/modules/user//admin///index.php',
                ),
                array('modules', 'user', 'admin', 'index.php'),
            ),
        );
    }

    /**
     * @param       $expected
     * @param array $urlInfo
     * @dataProvider dataForTestIsAdminPage
     */
    public function testIsAdminPage($expected, array $urlInfo)
    {
        $this->assertSame($expected, UrlParser::isAdminPage($urlInfo));
    }

    public function dataForTestIsAdminPage()
    {
        return array(
            // true patterns
            array(true, array('admin.php')),
            array(true, array('admin.php.back')),
            array(true, array('modules', 'foo', 'admin', 'index.php')),
            array(true, array('modules', 'xcore', 'include', 'script.php')),
            array(true, array('modules', 'system', 'admin.php')),
            array(true, array('modules', 'system', 'admin.php.back')),
            // false patterns
            array(false, array()),
            array(false, array('index.php')),
            array(false, array('modules', 'news', 'edit.php')),
        );
    }
}
