<?php

namespace Xoops\Tests\Unit\Entity;

use Xoops\Entity\GroupPermission;

class GroupPermissionTest extends \PHPUnit_Framework_TestCase
{
    public function testId()
    {
        $permission = new GroupPermission();
        $this->assertNull($permission->getId());
        $this->assertSame(123, $permission->setId(123)->getId());
    }

    public function testGroupId()
    {
        $permission = new GroupPermission();
        $this->assertNull($permission->getGroupId());
        $this->assertSame(123, $permission->setGroupId(123)->getGroupId());
    }

    public function testItemId()
    {
        $permission = new GroupPermission();
        $this->assertNull($permission->getItemId());
        $this->assertSame(123, $permission->setItemId(123)->getItemId());
    }

    public function testModuleId()
    {
        $permission = new GroupPermission();
        $this->assertNull($permission->getModuleId());
        $this->assertSame(123, $permission->setModuleId(123)->getModuleId());
    }

    public function testName()
    {
        $permission = new GroupPermission();
        $this->assertNull($permission->getName());
        $this->assertSame('DUMMY_NAME', $permission->setName('DUMMY_NAME')->getName());
    }
}
