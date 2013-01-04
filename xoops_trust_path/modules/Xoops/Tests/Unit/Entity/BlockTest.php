<?php

namespace Xoops\Tests\Unit\Entity;

use Xoops\Entity\Block;

class BlockTest extends \PHPUnit_Framework_TestCase
{
    public function testImportByPersistedObject()
    {
        $persistedObject = array(
            'bid'           => '2',
            'mid'           => '4',
            'func_num'      => '8',
            'options'       => 'option1|option2|option3',
            'name'          => 'DUMMY_NAME',
            'title'         => 'DUMMY_TITLE',
            'content'       => 'DUMMY_CONTENT',
            'side'          => '16',
            'weight'        => '32',
            'visible'       => '0',
            'block_type'    => 'DUMMY_BLOCK_TYPE',
            'c_type'        => 'DUMMY_CONTENT_TYPE',
            'isactive'      => '0',
            'dirname'       => 'DUMMY_DIRNAME',
            'func_file'     => 'DUMMY_FUNCTION_FILENAME',
            'show_func'     => 'DUMMY_SHOW_FUNCTION_NAME',
            'edit_func'     => 'DUMMY_EDIT_FUNCTION_NAME',
            'template'      => 'DUMMY_TEMPLATE_NAME',
            'bcachetime'    => '64',
            'last_modified' => '128',
        );

        $block = new Block();
        $block->importByPersistedObject($persistedObject);
        $this->assertSame('2', $block->getId());
        $this->assertSame('4', $block->getModuleId());
        $this->assertSame('8', $block->getFunctionNumber());
        $this->assertSame(array('option1', 'option2', 'option3'), $block->getOptions());
        $this->assertSame('DUMMY_NAME', $block->getName());
        $this->assertSame('DUMMY_TITLE', $block->getTitle());
        $this->assertSame('DUMMY_CONTENT', $block->getContent());
        $this->assertSame('16', $block->getSide());
        $this->assertSame('32', $block->getWeight());
        $this->assertFalse($block->isVisible());
        $this->assertSame('DUMMY_BLOCK_TYPE', $block->getBlockType());
        $this->assertSame('DUMMY_CONTENT_TYPE', $block->getContentType());
        $this->assertFalse($block->isActive());
        $this->assertSame('DUMMY_DIRNAME', $block->getDirname());
        $this->assertSame('DUMMY_FUNCTION_FILENAME', $block->getFunctionFilename());
        $this->assertSame('DUMMY_SHOW_FUNCTION_NAME', $block->getShowFunctionName());
        $this->assertSame('DUMMY_EDIT_FUNCTION_NAME', $block->getEditFunctionName());
        $this->assertSame('DUMMY_TEMPLATE_NAME', $block->getTemplateFilename());
        $this->assertSame('64', $block->getCacheTime());
        $this->assertSame('128', $block->getModifiedAt());
    }

    public function testExportForPersistence()
    {
        $block = new Block();
        $block
            ->setId('2')
            ->setModuleId('4')
            ->setFunctionNumber('8')
            ->setOptions(array('option1', 'option2', 'option3'))
            ->setName('DUMMY_NAME')
            ->setTitle('DUMMY_TITLE')
            ->setContent('DUMMY_CONTENT')
            ->setSide('16')
            ->setWeight('32')
            ->show()
            ->setBlockType('DUMMY_BLOCK_TYPE')
            ->setContentType('DUMMY_CONTENT_TYPE')
            ->activate()
            ->setDirname('DUMMY_DIRNAME')
            ->setFunctionFilename('DUMMY_FUNCTION_FILENAME')
            ->setShowFunctionName('DUMMY_SHOW_FUNCTION_NAME')
            ->setEditFunctionName('DUMMY_EDIT_FUNCTION_NAME')
            ->setTemplateFilename('DUMMY_TEMPLATE_NAME')
            ->setCacheTime('64')
            ->setModifiedAt('128');

        $this->assertSame(
            array(
                'bid'           => '2',
                'mid'           => '4',
                'func_num'      => '8',
                'options'       => 'option1|option2|option3',
                'name'          => 'DUMMY_NAME',
                'title'         => 'DUMMY_TITLE',
                'content'       => 'DUMMY_CONTENT',
                'side'          => '16',
                'weight'        => '32',
                'visible'       => 1,
                'block_type'    => 'DUMMY_BLOCK_TYPE',
                'c_type'        => 'DUMMY_CONTENT_TYPE',
                'isactive'      => 1,
                'dirname'       => 'DUMMY_DIRNAME',
                'func_file'     => 'DUMMY_FUNCTION_FILENAME',
                'show_func'     => 'DUMMY_SHOW_FUNCTION_NAME',
                'edit_func'     => 'DUMMY_EDIT_FUNCTION_NAME',
                'template'      => 'DUMMY_TEMPLATE_NAME',
                'bcachetime'    => '64',
                'last_modified' => '128',
            ),
            $block->exportForPersistence()
        );
    }

    public function testId()
    {
        $block = new Block();
        $this->assertNull($block->getId());
        $this->assertSame(1234, $block->setId(1234)->getId());
    }

    public function testModuleId()
    {
        $block = new Block();
        $this->assertSame(0, $block->getModuleId());
        $this->assertSame(1234, $block->setModuleId(1234)->getModuleId());
    }

    public function testFunctionNumber()
    {
        $block = new Block();
        $this->assertSame(0, $block->getFunctionNumber());
        $this->assertSame(123, $block->setFunctionNumber(123)->getFunctionNumber());
    }

    public function testOptions()
    {
        $block = new Block();
        $this->assertSame(array(), $block->getOptions());
        $this->assertSame(array('a', 'b', 'c'), $block->setOptions(array('a', 'b', 'c'))->getOptions());
    }

    public function testName()
    {
        $block = new Block();
        $this->assertNull($block->getName());
        $this->assertSame('DUMMY_NAME', $block->setName('DUMMY_NAME')->getName());
    }

    public function testTitle()
    {
        $block = new Block();
        $this->assertNull($block->getTitle());
        $this->assertSame('DUMMY_TITLE', $block->setTitle('DUMMY_TITLE')->getTitle());
    }

    public function testContent()
    {
        $block = new Block();
        $this->assertNull($block->getContent());
        $this->assertSame('DUMMY_CONTENT', $block->setContent('DUMMY_CONTENT')->getContent());
    }

    public function testSide()
    {
        $block = new Block();
        $this->assertSame(Block::SIDE_LEFT, $block->getSide());
        $this->assertSame(Block::SIDE_RIGHT, $block->setSide(Block::SIDE_RIGHT)->getSide());
    }

    public function testWeight()
    {
        $block = new Block();
        $this->assertSame(0, $block->getWeight());
        $this->assertSame(1234, $block->setWeight(1234)->getWeight());
    }

    public function testIsVisible()
    {
        $block = new Block();
        $this->assertFalse($block->isVisible());
        $this->assertTrue($block->show()->isVisible());
        $this->assertFalse($block->hide()->isVisible());
    }

    public function testBlockType()
    {
        $block = new Block();
        $this->assertNull($block->getBlockType());
        $this->assertSame(Block::BLOCK_TYPE_CUSTOM, $block->setBlockType(Block::BLOCK_TYPE_CUSTOM)->getBlockType());
    }

    public function testContentType()
    {
        $block = new Block();
        $this->assertNull($block->getContentType());
        $this->assertSame(Block::CONTENT_TYPE_HTML, $block->setContentType(Block::CONTENT_TYPE_HTML)->getContentType());
    }

    public function testIsActive()
    {
        $block = new Block();
        $this->assertFalse($block->isActive());
        $this->assertTrue($block->activate()->isActive());
        $this->assertFalse($block->inactivate()->isActive());
    }

    public function testDirname()
    {
        $block = new Block();
        $this->assertNull($block->getDirname());
        $this->assertSame('DUMMY_DIRNAME', $block->setDirname('DUMMY_DIRNAME')->getDirname());
    }

    public function testFunctionFilename()
    {
        $block = new Block();
        $this->assertNull($block->getFunctionFilename());
        $this->assertSame('DUMMY_FILENAME', $block->setFunctionFilename('DUMMY_FILENAME')->getFunctionFilename());
    }

    public function testShowFunctionName()
    {
        $block = new Block();
        $this->assertNull($block->getShowFunctionName());
        $this->assertSame(
            'DUMMY_FUNCTION_NAME',
            $block->setShowFunctionName('DUMMY_FUNCTION_NAME')->getShowFunctionName()
        );
    }

    public function testEditFunctionName()
    {
        $block = new Block();
        $this->assertNull($block->getEditFunctionName());
        $this->assertSame(
            'DUMMY_FUNCTION_NAME',
            $block->setEditFunctionName('DUMMY_FUNCTION_NAME')->getEditFunctionName()
        );
    }

    public function testTemplateFilename()
    {
        $block = new Block();
        $this->assertNull($block->getTemplateFilename());
        $this->assertSame('DUMMY_TEMPLATE', $block->setTemplateFilename('DUMMY_TEMPLATE')->getTemplateFilename());
    }

    public function testCacheTime()
    {
        $block = new Block();
        $this->assertSame(0, $block->getCacheTime());
        $this->assertSame(123, $block->setCacheTime(123)->getCacheTime());
    }

    public function testModifiedAt()
    {
        $block = new Block();
        $this->assertSame(time(), $block->getModifiedAt());
        $this->assertSame(999994149, $block->setModifiedAt(999994149)->getModifiedAt());
    }
}
