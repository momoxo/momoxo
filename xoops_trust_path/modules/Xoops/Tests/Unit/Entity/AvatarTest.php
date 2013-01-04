<?php

namespace Xoops\Tests\Unit\Entity;

use Xoops\Entity\Avatar;

class AvatarTest extends \PHPUnit_Framework_TestCase
{
    public function testImportByPersistedObject()
    {
        $persistedObject = array(
            'avatar_id'       => 123,
            'avatar_file'     => 'DUMMY_FILENAME',
            'avatar_name'     => 'DUMMY_NAME',
            'avatar_mimetype' => 'DUMMY_MIME_TYPE',
            'avatar_created'  => 999994149,
            'avatar_display'  => 1,
            'avatar_weight'   => 456,
            'avatar_type'     => 'DUMMY_TYPE',
        );

        $avatar = new Avatar();
        $avatar->importByPersistedObject($persistedObject);
        $this->assertSame(123, $avatar->getId());
        $this->assertSame('DUMMY_FILENAME', $avatar->getFilename());
        $this->assertSame('DUMMY_NAME', $avatar->getName());
        $this->assertSame('DUMMY_MIME_TYPE', $avatar->getMimeType());
        $this->assertSame(999994149, $avatar->getCreatedAt());
        $this->assertSame(true, $avatar->isDisplayed());
        $this->assertSame(456, $avatar->getWeight());
        $this->assertSame('DUMMY_TYPE', $avatar->getType());
    }

    public function testExportForPersistence()
    {
        $avatar = new Avatar();
        $avatar
            ->setId(123)
            ->setFilename('DUMMY_FILENAME')
            ->setName('DUMMY_NAME')
            ->setMimeType('DUMMY_MIME_TYPE')
            ->setCreatedAt(999994149)
            ->hide()
            ->setWeight(456)
            ->setType('DUMMY_TYPE');

        $this->assertSame(
            array(
                'avatar_id'       => 123,
                'avatar_file'     => 'DUMMY_FILENAME',
                'avatar_name'     => 'DUMMY_NAME',
                'avatar_mimetype' => 'DUMMY_MIME_TYPE',
                'avatar_created'  => 999994149,
                'avatar_display'  => 0,
                'avatar_weight'   => 456,
                'avatar_type'     => 'DUMMY_TYPE',
            ),
            $avatar->exportForPersistence()
        );
    }

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
