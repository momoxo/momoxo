<?php

namespace XCore\Database;

/**
 * Insert query generator
 */
class InsertQuery
{
    /**
     * @var string
     */
    private $table;

    /**
     * @var array
     */
    private $values = array();

    /**
     * Set table name
     * @param string $table
     * @return $this
     */
    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * Set values
     * @param array $values
     * @return $this
     */
    public function setValues(array $values)
    {
        $this->values = $values;
        return $this;
    }

    /**
     * Return parameters for prepared statement
     * @return array
     */
    public function getParameters()
    {
        $parameters = array();

        foreach ($this->values as $key => $value) {
            $parameters[':'.$key] = $value;
        }

        return $parameters;
    }

    /**
     * Return prepared statement SQL
     * @return string
     */
    public function getSQL()
    {
        $columns = array();
        $placeholders = array();

        foreach ($this->values as $key => $value) {
            $columns[] = $key;
            $placeholders[] = ':'.$key;
        }

        $columns = implode(', ', $columns);
        $placeholders = implode(', ', $placeholders);

        return sprintf('INSERT INTO %s (%s) VALUES (%s)', $this->table, $columns, $placeholders);
    }

    /**
     * Return prepared statement SQL
     * @return string
     */
    public function __toString()
    {
        return $this->getSQL();
    }
}
