<?php

namespace Xoops\Tests\Helper;

use Xoops\Database\MySQLDatabase;
use Momoxo\Installer\Database\SqlUtility;

class TestDatabaseFactory
{
    /**
     * Return new database connection
     * @return MySQLDatabase
     */
    public static function getDatabase()
    {
        static $db;

        if ($db === null) {
            $db = new MySQLDatabase();
            $db->connect(
                array(
                    'host'     => $_SERVER['XOOPS_TEST_DB_HOST'],
                    'name'     => $_SERVER['XOOPS_TEST_DB_NAME'],
                    'charset'  => 'utf8',
                    'user'     => $_SERVER['XOOPS_TEST_DB_USER'],
                    'password' => $_SERVER['XOOPS_TEST_DB_PASS'],
                )
            );
            $db->setPrefix($_SERVER['XOOPS_TEST_DB_PREFIX'].'_');
        }

        return $db;
    }

    public static function resetSchema()
    {
        static $cachedQueries;

        $db = new MySQLDatabase();
        $db->connect(
            array(
                'host'     => $_SERVER['XOOPS_TEST_DB_HOST'],
                'charset'  => 'utf8',
                'user'     => $_SERVER['XOOPS_TEST_DB_USER'],
                'password' => $_SERVER['XOOPS_TEST_DB_PASS'],
            )
        );
        $db->setPrefix($_SERVER['XOOPS_TEST_DB_PREFIX'].'_');

        $db->query('DROP DATABASE IF EXISTS '.$_SERVER['XOOPS_TEST_DB_NAME']);
        $db->query('CREATE DATABASE '.$_SERVER['XOOPS_TEST_DB_NAME'].' DEFAULT CHARACTER SET utf8');
        $db->query('USE '.$_SERVER['XOOPS_TEST_DB_NAME']);

        // @todo インストーラに依存しないようする

        if ($cachedQueries === null) {
            $sqlUtility = new SqlUtility();
            $queries = array();
            $sqlUtility->splitMySqlFile(
                $queries,
                file_get_contents(__DIR__.'/../../../../../html/install/sql/mysql.structure.sql')
            );

            foreach ($queries as $query) {
                $queryInfo = $sqlUtility->prefixQuery($query, $_SERVER['XOOPS_TEST_DB_PREFIX']);
                $cachedQueries[] = $queryInfo[0];
            }
        }

        foreach ($cachedQueries as $query) {
            $db->query($query);
        }
    }
}
