<?php

namespace XCore\Database;

use PDO;
use PDOStatement;
use XCore\Database\DatabaseInterface;

class MySQLDatabase implements DatabaseInterface
{
    /**
     * @var string
     */
    private $prefix;

    /**
     * @var PDO
     */
    private $pdo;

    /**
     * {@inherit}
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * {@inherit}
     */
    public function prefix($table)
    {
        return $this->prefix.$table;
    }

    /**
     * {@inherit}
     */
    public function connect(array $params)
    {
        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', $params['host'], $params['dbname'], $params['charset']);
        $this->pdo = new PDO($dsn, $params['username'], $params['password'], array(
            PDO::ATTR_ORACLE_NULLS       => PDO::NULL_NATURAL, // NULL is available
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_AUTOCOMMIT         => true,
        ));

        return $this;
    }

    /**
     * {@inherit}
     */
    public function beginTransaction()
    {
        if ($this->pdo->beginTransaction() === false) {
            throw new \RuntimeException('Failed to begin transaction');
        }

        return $this;
    }

    /**
     * {@inherit}
     */
    public function rollBack()
    {
        if ($this->pdo->rollBack() === false) {
            throw new \RuntimeException('Failed to rollback transaction');
        }

        return $this;
    }

    /**
     * {@inherit}
     */
    public function commit()
    {
        if ($this->pdo->commit() === false) {
            throw new \RuntimeException('Failed to commit transaction');
        }

        return $this;
    }

    /**
     * {@inherit}
     */
    public function query($query)
    {
        return $this->pdo->query($query);
    }

    /**
     * {@inherit}
     */
    public function prepare($query)
    {
        return $this->pdo->prepare($query);
    }

    /**
     * Returns the ID of the last inserted row or sequence value
     * @return string
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}
