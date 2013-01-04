<?php

namespace Xoops\Tests\Join\Repository;

use Xoops\Tests\Helper\TestDatabaseFactory;

use Xoops\Repository\TemplateFileRepository;
use Xoops\Entity\TemplateFile;

class TemplateFileRepositoryTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        TestDatabaseFactory::resetSchema();
    }

    /**
     * @return TemplateFileRepository
     */
    public function getRepository()
    {
        return new TemplateFileRepository(TestDatabaseFactory::getDatabase());
    }

    public function testPersist()
    {
        $templateFile = new TemplateFile();
        $templateFile
            ->setReferenceId(2)
            ->setModuleName('DUMMY_MODULE_NAME')
            ->setTemplateSetName('DUMMY_TEMPLATE_SET_NAME')
            ->setFilename('DUMMY_FILENAME')
            ->setDescription('DUMMY_DESCRIPTION')
            ->setModifiedAt(4)
            ->setImportedAt(8)
            ->setType(TemplateFile::TYPE_MODULE)
            ->setSource('DUMMY_SOURCE');

        $repository = $this->getRepository();

        // insert test
        $repository->persist($templateFile);

        $this->assertSame('1', $templateFile->getId());
        $this->assertTableSame(
            array(
                array(
                    'tpl_id'           => '1',
                    'tpl_refid'        => '2',
                    'tpl_module'       => 'DUMMY_MODULE_NAME',
                    'tpl_tplset'       => 'DUMMY_TEMPLATE_SET_NAME',
                    'tpl_file'         => 'DUMMY_FILENAME',
                    'tpl_desc'         => 'DUMMY_DESCRIPTION',
                    'tpl_lastmodified' => '4',
                    'tpl_lastimported' => '8',
                    'tpl_type'         => TemplateFile::TYPE_MODULE,
                ),
            ),
            'tplfile'
        );
        $this->assertTableSame(
            array(
                array(
                    'tpl_id'     => '1',
                    'tpl_source' => 'DUMMY_SOURCE',
                ),
            ),
            'tplsource'
        );

        // update test
        $templateFile
            ->setDescription('NEW_DESCRIPTION')
            ->setSource('NEW_SOURCE');
        $repository->persist($templateFile);

        $this->assertSame('1', $templateFile->getId());
        $this->assertTableSame(
            array(
                array(
                    'tpl_id'           => '1',
                    'tpl_refid'        => '2',
                    'tpl_module'       => 'DUMMY_MODULE_NAME',
                    'tpl_tplset'       => 'DUMMY_TEMPLATE_SET_NAME',
                    'tpl_file'         => 'DUMMY_FILENAME',
                    'tpl_desc'         => 'NEW_DESCRIPTION',
                    'tpl_lastmodified' => '4',
                    'tpl_lastimported' => '8',
                    'tpl_type'         => TemplateFile::TYPE_MODULE,
                ),
            ),
            'tplfile'
        );
        $this->assertTableSame(
            array(
                array(
                    'tpl_id'     => '1',
                    'tpl_source' => 'NEW_SOURCE',
                ),
            ),
            'tplsource'
        );
    }

    public static function assertTableSame(array $expectedRows, $tableName)
    {
        $db = TestDatabaseFactory::getDatabase();
        $actualRows = $db->query('SELECT * FROM '.$db->prefix($tableName))->fetchAll();
        self::assertSame($expectedRows, $actualRows, sprintf('The table "%s" contents are not same', $tableName));
    }
}
