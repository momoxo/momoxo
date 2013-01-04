<?php

namespace Xoops\Tests\Unit\Entity;

use Xoops\Entity\ConfigItem;

class ConfigItemTest extends \PHPUnit_Framework_TestCase
{
    public function testImportByPersistedObject()
    {
        $persistedObject = array(
            'conf_id'        => '123',
            'conf_modid'     => '456',
            'conf_catid'     => '789',
            'conf_name'      => 'DUMMY_NAME',
            'conf_title'     => 'DUMMY_TITLE',
            'conf_value'     => 'DUMMY_VALUE',
            'conf_desc'      => 'DUMMY_DESCRIPTION',
            'conf_formtype'  => 'DUMMY_FORM_TYPE',
            'conf_valuetype' => 'DUMMY_VALUE_TYPE',
            'conf_order'     => '987',
        );

        $item = new ConfigItem();
        $item->importByPersistedObject($persistedObject);
        $this->assertSame('123', $item->getId());
        $this->assertSame('456', $item->getModuleId());
        $this->assertSame('789', $item->getCategoryId());
        $this->assertSame('DUMMY_NAME', $item->getName());
        $this->assertSame('DUMMY_TITLE', $item->getTitle());
        $this->assertSame('DUMMY_VALUE', $item->getValue());
        $this->assertSame('DUMMY_DESCRIPTION', $item->getDescription());
        $this->assertSame('DUMMY_FORM_TYPE', $item->getFormType());
        $this->assertSame('DUMMY_VALUE_TYPE', $item->getValueType());
        $this->assertSame('987', $item->getOrder());
    }

    public function testExportForPersistence()
    {
        $item = new ConfigItem();
        $item
            ->setId('123')
            ->setModuleId('456')
            ->setCategoryId('789')
            ->setName('DUMMY_NAME')
            ->setTitle('DUMMY_TITLE')
            ->setValue('DUMMY_VALUE')
            ->setDescription('DUMMY_DESCRIPTION')
            ->setFormType('DUMMY_FORM_TYPE')
            ->setValueType('DUMMY_VALUE_TYPE')
            ->setOrder('987');

        $this->assertSame(
            array(
                'conf_id'        => '123',
                'conf_modid'     => '456',
                'conf_catid'     => '789',
                'conf_name'      => 'DUMMY_NAME',
                'conf_title'     => 'DUMMY_TITLE',
                'conf_value'     => 'DUMMY_VALUE',
                'conf_desc'      => 'DUMMY_DESCRIPTION',
                'conf_formtype'  => 'DUMMY_FORM_TYPE',
                'conf_valuetype' => 'DUMMY_VALUE_TYPE',
                'conf_order'     => '987',
            ),
            $item->exportForPersistence()
        );
    }

    public function testId()
    {
        $item = new ConfigItem();
        $this->assertNull($item->getId());
        $this->assertSame(123, $item->setId(123)->getId());
    }

    public function testModuleId()
    {
        $item = new ConfigItem();
        $this->assertNull($item->getModuleId());
        $this->assertSame(123, $item->setModuleId(123)->getModuleId());
    }

    public function testCategoryId()
    {
        $item = new ConfigItem();
        $this->assertNull($item->getCategoryId());
        $this->assertSame(123, $item->setCategoryId(123)->getCategoryId());
    }

    public function testName()
    {
        $item = new ConfigItem();
        $this->assertNull($item->getName());
        $this->assertSame('DUMMY_NAME', $item->setName('DUMMY_NAME')->getName());
    }

    public function testTitle()
    {
        $item = new ConfigItem();
        $this->assertNull($item->getTitle());
        $this->assertSame('DUMMY_TITLE', $item->setTitle('DUMMY_TITLE')->getTitle());
    }

    public function testValue()
    {
        $item = new ConfigItem();
        $this->assertNull($item->getValue());
        $this->assertSame('DUMMY_VALUE', $item->setValue('DUMMY_VALUE')->getValue());
    }

    public function testDescription()
    {
        $item = new ConfigItem();
        $this->assertNull($item->getDescription());
        $this->assertSame('DUMMY_DESCRIPTION', $item->setDescription('DUMMY_DESCRIPTION')->getDescription());
    }

    public function testFormType()
    {
        $item = new ConfigItem();
        $this->assertNull($item->getFormType());
        $this->assertSame('DUMMY_FORM_TYPE', $item->setFormType('DUMMY_FORM_TYPE')->getFormType());
    }

    public function testValueType()
    {
        $item = new ConfigItem();
        $this->assertNull($item->getValueType());
        $this->assertSame('DUMMY_VALUE_TYPE', $item->setValueType('DUMMY_VALUE_TYPE')->getValueType());
    }

    public function testOrder()
    {
        $item = new ConfigItem();
        $this->assertNull($item->getOrder());
        $this->assertSame(123, $item->setOrder(123)->getOrder());
    }
}
