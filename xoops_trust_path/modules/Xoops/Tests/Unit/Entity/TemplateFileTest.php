<?php

namespace Xoops\Tests\Unit\Entity;

use Xoops\Entity\TemplateFile;

class TemplateFileTest extends \PHPUnit_Framework_TestCase
{
    public function testImportByPersistedObject()
    {
        $persistedObject = array(
            'tpl_id'           => 123,
            'tpl_refid'        => 456,
            'tpl_tplset'       => 'DUMMY_TPL_SET',
            'tpl_file'         => 'DUMMY_FILE',
            'tpl_desc'         => 'DUMMY_DESC',
            'tpl_lastmodified' => 123456789,
            'tpl_lastimported' => 987654321,
            'tpl_module'       => 'DUMMY_MODULE',
            'tpl_type'         => 'DUMMY_TYPE',
            'tpl_source'       => 'DUMMY_SOURCE',
        );

        $templateFile = new TemplateFile();
        $templateFile->importByPersistedObject($persistedObject);

        $this->assertSame(123, $templateFile->getId());
        $this->assertSame(456, $templateFile->getReferenceId());
        $this->assertSame('DUMMY_TPL_SET', $templateFile->getTemplateSetName());
        $this->assertSame('DUMMY_FILE', $templateFile->getFilename());
        $this->assertSame('DUMMY_DESC', $templateFile->getDescription());
        $this->assertSame(123456789, $templateFile->getModifiedAt());
        $this->assertSame(987654321, $templateFile->getImportedAt());
        $this->assertSame('DUMMY_MODULE', $templateFile->getModuleName());
        $this->assertSame('DUMMY_TYPE', $templateFile->getType());
        $this->assertSame('DUMMY_SOURCE', $templateFile->getSource());
    }

    public function testExportForPersistence()
    {
        $templateFile = new TemplateFile();
        $templateFile
            ->setId(123)
            ->setReferenceId(456)
            ->setTemplateSetName('DUMMY_TPL_SET')
            ->setFilename('DUMMY_FILE')
            ->setDescription('DUMMY_DESC')
            ->setModifiedAt(123456789)
            ->setImportedAt(987654321)
            ->setModuleName('DUMMY_MODULE')
            ->setType('DUMMY_TYPE')
            ->setSource('DUMMY_SOURCE');

        $persistingObject = $templateFile->exportForPersistence();

        $this->assertSame(
            array(
                'tpl_id'           => 123,
                'tpl_refid'        => 456,
                'tpl_tplset'       => 'DUMMY_TPL_SET',
                'tpl_file'         => 'DUMMY_FILE',
                'tpl_desc'         => 'DUMMY_DESC',
                'tpl_lastmodified' => 123456789,
                'tpl_lastimported' => 987654321,
                'tpl_module'       => 'DUMMY_MODULE',
                'tpl_type'         => 'DUMMY_TYPE',
                'tpl_source'       => 'DUMMY_SOURCE',
            ),
            $persistingObject
        );
    }

    public function testId()
    {
        $templateFile = new TemplateFile();
        $this->assertNull($templateFile->getId());
        $this->assertSame(123, $templateFile->setId(123)->getId());
    }

    public function testReferenceId()
    {
        $templateFile = new TemplateFile();
        $this->assertNull($templateFile->getReferenceId());
        $this->assertSame(123, $templateFile->setReferenceId(123)->getReferenceId());
    }

    public function testTemplateSetName()
    {
        $templateFile = new TemplateFile();
        $this->assertNull($templateFile->getTemplateSetName());
        $this->assertSame('DUMMY_NAME', $templateFile->setTemplateSetName('DUMMY_NAME')->getTemplateSetName());
    }

    public function testFilename()
    {
        $templateFile = new TemplateFile();
        $this->assertNull($templateFile->getFilename());
        $this->assertSame('DUMMY_FILENAME', $templateFile->setFilename('DUMMY_FILENAME')->getFilename());
    }

    public function testDescription()
    {
        $templateFile = new TemplateFile();
        $this->assertNull($templateFile->getDescription());
        $this->assertSame('DUMMY_DESC', $templateFile->setDescription('DUMMY_DESC')->getDescription());
    }

    public function testModifiedAt()
    {
        $templateFile = new TemplateFile();
        $this->assertNull($templateFile->getModifiedAt());
        $this->assertSame(999994149, $templateFile->setModifiedAt(999994149)->getModifiedAt());
    }

    public function testImportedAt()
    {
        $templateFile = new TemplateFile();
        $this->assertNull($templateFile->getImportedAt());
        $this->assertSame(999994149, $templateFile->setImportedAt(999994149)->getImportedAt());
    }

    public function testModuleName()
    {
        $templateFile = new TemplateFile();
        $this->assertNull($templateFile->getModuleName());
        $this->assertSame('DUMMY_NAME', $templateFile->setModuleName('DUMMY_NAME')->getModuleName());
    }

    public function testSetType()
    {
        $templateFile = new TemplateFile();
        $this->assertNull($templateFile->getType());
        $this->assertSame('block', $templateFile->setType(TemplateFile::TYPE_BLOCK)->getType());
        $this->assertSame('module', $templateFile->setType(TemplateFile::TYPE_MODULE)->getType());
    }

    public function testSource()
    {
        $templateFile = new TemplateFile();
        $this->assertNull($templateFile->getSource());
        $this->assertSame('DUMMY_SOURCE', $templateFile->setSource('DUMMY_SOURCE')->getSource());
    }
}
