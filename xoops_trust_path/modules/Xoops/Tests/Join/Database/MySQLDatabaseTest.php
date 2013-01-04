<?php

namespace Xoops\Tests\Join\Database;

use Xoops\Database\MySQLDatabase;

class MySQLDatabaseTest extends \PHPUnit_Framework_TestCase
{
    private function getDatabaseConfig()
    {
        return array(
            'host'     => $_SERVER['XOOPS_TEST_DB_HOST'],
            'name'     => $_SERVER['XOOPS_TEST_DB_NAME'],
            'charset'  => 'utf8',
            'user'     => $_SERVER['XOOPS_TEST_DB_USER'],
            'password' => $_SERVER['XOOPS_TEST_DB_PASS'],
        );
    }

    public function testInsertAndSelect()
    {
        $db = new MySQLDatabase();
        $db->connect($this->getDatabaseConfig());
        $db->query('DROP TABLE IF EXISTS the_table');
        $db->query('CREATE TABLE the_table (the_column VARCHAR(255))');

        $statement = $db->prepare('INSERT INTO the_table (the_column) VALUES (:placeholder)');
        $statement->execute(array(':placeholder' => 'DUMMY_DATA1'));
        $statement->execute(array(':placeholder' => 'DUMMY_DATA2'));
        $statement->execute(array(':placeholder' => 'DUMMY_DATA3'));

        $rows = $db->query('SELECT * FROM the_table')->fetchAll();
        $this->assertSame(
            array(
                array('the_column' => 'DUMMY_DATA1'),
                array('the_column' => 'DUMMY_DATA2'),
                array('the_column' => 'DUMMY_DATA3'),
            ),
            $rows
        );
    }

    public function testTransaction()
    {
        $db = new MySQLDatabase();
        $db->connect($this->getDatabaseConfig());
        $db->query('DROP TABLE IF EXISTS the_table');
        $db->query(
            'CREATE TABLE the_table ('.
            'id INT(11) AUTO_INCREMENT,'.
            'the_column VARCHAR(255),'.
            'PRIMARY KEY (id)'.
            ') ENGINE=InnoDB'
        );

        $db->beginTransaction();
        $db->query('INSERT INTO the_table (the_column) VALUES (123)');
        $this->assertSame('1', $db->lastInsertId());
        $db->rollBack();

        $db->beginTransaction();
        $db->query('INSERT INTO the_table (the_column) VALUES (456)');
        $this->assertSame('2', $db->lastInsertId());
        $db->commit();

        $rows = $db->query('SELECT * FROM the_table')->fetchAll();

        $this->assertSame(
            array(
                array(
                    'id' => '2',
                    'the_column' => '456',
                )
            ),
            $rows
        );
    }
}
