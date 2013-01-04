<?php

namespace Xoops\Tests\Unit\Entity;

use Xoops\Entity\ConfigCategory;

class ConfigCategoryTest extends \PHPUnit_Framework_TestCase
{
    public function testImportByPersistedObject()
    {
        $persistedObject = array(
            'confcat_id'    => '123',
            'confcat_name'  => 'DUMMY_NAME',
            'confcat_order' => '456',
        );

        $category = new ConfigCategory();
        $category->importByPersistedObject($persistedObject);

        $this->assertSame('123', $category->getId());
        $this->assertSame('DUMMY_NAME', $category->getName());
        $this->assertSame('456', $category->getOrder());
    }

    public function testExportForPersistence()
    {
        $category = new ConfigCategory();
        $category
            ->setId(123)
            ->setName('DUMMY_NAME')
            ->setOrder(456);

        $this->assertSame(
            array(
                'confcat_id'    => 123,
                'confcat_name'  => 'DUMMY_NAME',
                'confcat_order' => 456,
            ),
            $category->exportForPersistence()
        );
    }

    public function testId()
    {
        $category = new ConfigCategory();
        $this->assertNull($category->getId());
        $this->assertSame(123, $category->setId(123)->getId());
    }

    public function testName()
    {
        $category = new ConfigCategory();
        $this->assertNull($category->getName());
        $this->assertSame('DUMMY_NAME', $category->setName('DUMMY_NAME')->getName());
    }

    public function testOrder()
    {
        $category = new ConfigCategory();
        $this->assertNull($category->getOrder());
        $this->assertSame(123, $category->setOrder(123)->getOrder());
    }
}
