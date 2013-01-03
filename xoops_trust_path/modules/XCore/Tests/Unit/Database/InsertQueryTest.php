<?php

namespace XCore\Tests\Unit\Database;

use XCore\Database\InsertQuery;

class InsertQueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function sampleUsage()
    {
        $query = new InsertQuery();
        $query
            ->setTable('xoops_users')
            ->setValues(array(
                'name'     => 'alice',
                'email'    => 'alice@example.com',
                'password' => 'p@ssW0rd',
            ));

        $this->assertSame(
            'INSERT INTO xoops_users (name, email, password) VALUES (:name, :email, :password)',
            $query->getSQL());

        $this->assertSame(
            'INSERT INTO xoops_users (name, email, password) VALUES (:name, :email, :password)',
            strval($query));

        $this->assertSame(
            array(
                ':name'     => 'alice',
                ':email'    => 'alice@example.com',
                ':password' => 'p@ssW0rd',
            ),
            $query->getParameters());
    }
}
