<?php

namespace Xoops\Tests\Unit\Entity;

use Xoops\Entity\Group;

class GroupTest extends \PHPUnit_Framework_TestCase
{
    public function testId()
    {
        $group = new Group();
        $this->assertNull($group->getId());
        $this->assertSame(1234, $group->setId(1234)->getId());
    }

    public function testName()
    {
        $group = new Group();
        $this->assertNull($group->getName());
        $this->assertSame('DUMMY_NAME', $group->setName('DUMMY_NAME')->getName());
    }

    public function testDescription()
    {
        $group = new Group();
        $this->assertNull($group->getDescription());
        $this->assertSame('DUMMY_DESC', $group->setDescription('DUMMY_DESC')->getDescription());
    }

    public function testType()
    {
        $group = new Group();
        $this->assertNull($group->getType());
        $this->assertSame('DUMMY_TYPE', $group->setType('DUMMY_TYPE')->getType());
    }

}
