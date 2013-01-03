<?php

namespace XCore\Tests\Unit\Database;

use XCore\Database\UpdateQuery;

class UpdateQueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function sampleUsage()
    {
        $query = new UpdateQuery();
        $query
            ->setKeyName('uid')
            ->setKeyValue('12345')
            ->setTable('xoops_users')
            ->setValues(array(
                'name'     => 'alice',
                'email'    => 'alice@example.com',
                'password' => 'p@ssW0rd',
            ));

        $this->assertSame(
            'UPDATE xoops_users SET name = :name, email = :email, password = :password WHERE uid = :uid',
            $query->getSQL()
        );

        $this->assertSame(
            'UPDATE xoops_users SET name = :name, email = :email, password = :password WHERE uid = :uid',
            strval($query)
        );

        $this->assertSame(array(
            ':name'     => 'alice',
            ':email'    => 'alice@example.com',
            ':password' => 'p@ssW0rd',
            ':uid'      => '12345',
        ), $query->getParameters());
    }
}
