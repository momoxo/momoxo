<?php

namespace Xoops\Tests\Unit\Entity;

use Xoops\Entity\Avatar;

class AvatarTest extends \PHPUnit_Framework_TestCase
{
    public function testId()
    {
        $avatar = new Avatar();
        $this->assertNull($avatar->getId());
        $this->assertSame(1223, $avatar->setId(1223)->getId());
    }

    public function testFilename()
    {
        $avatar = new Avatar();
        $this->assertNull($avatar->getFilename());
        $this->assertSame('DUMMY_FILENAME', $avatar->setFilename('DUMMY_FILENAME')->getFilename());
    }

    public function testName()
    {
        $avatar = new Avatar();
        $this->assertNull($avatar->getName());
        $this->assertSame('DUMMY_NAME', $avatar->setName('DUMMY_NAME')->getName());
    }

    public function testMimeType()
    {
        $avatar = new Avatar();
        $this->assertNull($avatar->getMimeType());
        $this->assertSame('DUMMY_MIME_TYPE', $avatar->setMimeType('DUMMY_MIME_TYPE')->getMimeType());
    }

    public function testCreatedAt()
    {
        $avatar = new Avatar();
        $this->assertNull($avatar->getCreatedAt());
        $this->assertSame(999994149, $avatar->setCreatedAt(999994149)->getCreatedAt());
    }

    public function testDisplay()
    {
        $avatar = new Avatar();
        $this->assertTrue($avatar->isDisplayed());
        $this->assertFalse($avatar->hide()->isDisplayed());
        $this->assertTrue($avatar->display()->isDisplayed());
    }

    public function testWeight()
    {
        $avatar = new Avatar();
        $this->assertSame(0, $avatar->getWeight());
        $this->assertSame(1233, $avatar->setWeight(1233)->getWeight());
    }

    public function testType()
    {
        $avatar = new Avatar();
        $this->assertNull($avatar->getType());
        $this->assertSame(Avatar::TYPE_SYSTEM, $avatar->setType(Avatar::TYPE_SYSTEM)->getType());
    }
}
