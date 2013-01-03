<?php

namespace XCore\Tests\Unit\Repository;

use Mockery as m;
use XCore\Repository\Repository;
use XCore\Database\DatabaseInterface;

class RepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Return Database mock object
     * @return \XCore\Database\DatabaseInterface
     */
    private function getDummyDatabase()
    {
        return $this->getMock('XCore\Database\DatabaseInterface');
    }

    public function testTable()
    {
        $repository = new Repository($this->getDummyDatabase());
        $this->assertNull($repository->getTable());
        $this->assertSame('DUMMY_TABLE', $repository->setTable('DUMMY_TABLE')->getTable());
    }

    public function testPrefix()
    {
        $repository = new Repository($this->getDummyDatabase());
        $this->assertNull($repository->getPrefix());
        $this->assertSame('prefix', $repository->setPrefix('prefix')->getPrefix());
    }

    public function testEntityClass()
    {
        $repository = new Repository($this->getDummyDatabase());
        $this->assertNull($repository->getEntityClass());
        $this->assertSame('DUMMY_ENTITY_CLASS', $repository->setEntityClass('DUMMY_ENTITY_CLASS')->getEntityClass());
    }

    public function testId()
    {
        $repository = new Repository($this->getDummyDatabase());
        $this->assertNull($repository->getId());
        $this->assertSame('DUMMY_ID', $repository->setId('DUMMY_ID')->getId());
    }

    public function testPersistWithNewEntity()
    {
        $db = m::mock('XCore\Database\DatabaseInterface');
        $statement = m::mock('stdClass');

        $entity = m::mock('stdClass', array(
            'isNew'   => true,
            'toArray' => array(
                'id'      => null,
                'column1' => 'foo',
                'column2' => 'bar',
                'column3' => 'baz',
            ),
        ));

        $db->shouldReceive('prefix')->with('bar_baz')->andReturn('foo_bar_baz');
        $db->shouldReceive('prepare')->with(
            'INSERT INTO foo_bar_baz (column1, column2, column3) '.
            'VALUES (:column1, :column2, :column3)'
        )->andReturn($statement)->once();

        $statement->shouldReceive('execute')->with(array(
            ':column1' => 'foo',
            ':column2' => 'bar',
            ':column3' => 'baz',
        ))->once();

        $db->shouldReceive('lastInsertId')->andReturn(123)->once();

        $entity->shouldReceive('set')->with('id', 123)->once();
        $entity->shouldReceive('unsetNew')->once();

        $repository = new Repository($db);
        $repository
            ->setEntityClass('stdClass')
            ->setId('id')
            ->setTable('baz')
            ->setPrefix('bar');

        $repository->persist($entity);
    }

    public function testPersistWithOldEntity()
    {
        $db = m::mock('XCore\Database\DatabaseInterface');
        $statement = m::mock('stdClass');

        $entity = m::mock('stdClass', array(
            'isNew'   => false,
            'toArray' => array(
                'id'      => 123,
                'column1' => 'foo',
                'column2' => 'bar',
                'column3' => 'baz',
            ),
        ));

        $db->shouldReceive('prefix')->with('bar_baz')->andReturn('foo_bar_baz');
        $db->shouldReceive('prepare')->with(
            'UPDATE foo_bar_baz SET column1 = :column1, column2 = :column2, column3 = :column3 WHERE id = :id'
        )->andReturn($statement)->once();

        $statement->shouldReceive('execute')->with(array(
            ':column1' => 'foo',
            ':column2' => 'bar',
            ':column3' => 'baz',
            ':id'      => 123,
        ))->once();

        $repository = new Repository($db);
        $repository
            ->setEntityClass('stdClass')
            ->setId('id')
            ->setTable('baz')
            ->setPrefix('bar');

        $repository->persist($entity);
    }
}
