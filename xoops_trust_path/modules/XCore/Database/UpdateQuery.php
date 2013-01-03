<?php

namespace XCore\Database;

/**
 * Update query generator
 */
class UpdateQuery
{
    /**
     * @var string
     */
    private $table;

    /**
     * @var string
     */
    private $keyName;

    /**
     * @var string
     */
    private $keyValue;

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
     * Set primary key name
     * @param string $keyName
     * @return $this
     */
    public function setKeyName($keyName)
    {
        $this->keyName = $keyName;
        return $this;
    }

    /**
     * Set key value
     * @param string $keyValue
     * @return $this
     */
    public function setKeyValue($keyValue)
    {
        $this->keyValue = $keyValue;
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

        foreach ( $this->values as $key => $value ) {
            $parameters[':'.$key] = $value;
        }

        $parameters[':'.$this->keyName] = $this->keyValue;

        return $parameters;
    }

    /**
     * Return prepared statement SQL
     * @return string
     */
    public function getSQL()
    {
        $columns = array();

        foreach ($this->values as $key => $value) {
            $columns[] = sprintf('%s = :%s', $key, $key);
        }

        $columns = implode(', ', $columns);

        return sprintf('UPDATE %s SET %s WHERE %s = :%s', $this->table, $columns, $this->keyName, $this->keyName);
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
