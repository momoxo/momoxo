<?php

namespace Xoops\Tests\Unit\Database;

use Xoops\Database\MySQLDatabase;

class MySQLDatabaseTest extends \PHPUnit_Framework_TestCase
{
    public function testPrefix()
    {
        $database = new MySQLDatabase();
        $database->setPrefix('foo_');
        $this->assertSame('foo_table', $database->prefix('table'));
    }
}
