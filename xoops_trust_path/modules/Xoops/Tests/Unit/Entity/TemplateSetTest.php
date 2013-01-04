<?php

namespace Xoops\Tests\Unit\Entity;

use Xoops\Entity\TemplateSet;

class TemplateSetTest extends \PHPUnit_Framework_TestCase
{
    public function testReconstructionByPersistedObject()
    {
        $persistedObject = array(
            'tplset_id'      => '1234',
            'tplset_name'    => 'DUMMY_NAME',
            'tplset_desc'    => 'DUMMY_DESCRIPTION',
            'tplset_credits' => 'DUMMY_CREDIT',
            'tplset_created' => '999994149',
        );

        $templateSet = new TemplateSet();
        $templateSet->importByPersistedObject($persistedObject);

        $this->assertSame('1234', $templateSet->getId());
        $this->assertSame('DUMMY_NAME', $templateSet->getName());
        $this->assertSame('DUMMY_DESCRIPTION', $templateSet->getDescription());
        $this->assertSame('DUMMY_CREDIT', $templateSet->getCredits());
        $this->assertSame('999994149', $templateSet->getCreatedAt());
    }

    public function testExportingForPersistence()
    {
        $templateSet = new TemplateSet();
        $templateSet
            ->setName('DUMMY_NAME')
            ->setDescription('DUMMY_DESCRIPTION')
            ->setCredits('DUMMY_CREDITS')
            ->setCreatedAt('999994149');

        $persistingObject = $templateSet->exportForPersistence();

        $this->assertSame(
            array(
                'tplset_id'      => null,
                'tplset_name'    => 'DUMMY_NAME',
                'tplset_desc'    => 'DUMMY_DESCRIPTION',
                'tplset_credits' => 'DUMMY_CREDITS',
                'tplset_created' => '999994149',
            ),
            $persistingObject
        );
    }

    public function testId()
    {
        $templateSet = new TemplateSet();
        $this->assertNull($templateSet->getId());
    }

    public function testName()
    {
        $templateSet = new TemplateSet();
        $this->assertNull($templateSet->getName());
        $this->assertSame('DUMMY_NAME', $templateSet->setName('DUMMY_NAME')->getName());
    }
}
