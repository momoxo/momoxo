<?php

namespace XCore\Repository;

use XCore\Database\DatabaseInterface;
use XCore\Repository\RepositoryInterface;
use XCore\Database\UpdateQuery;
use XCore\Database\InsertQuery;

class Repository implements RepositoryInterface
{
    /**
     * @var DatabaseInterface
     */
    protected $db;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @var string
     */
    protected $id;

    /**
     * {@inherit}
     */
    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }

    /**
     * {@inherit}
     */
    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * {@inherit}
     */
    public function getTable()
    {
        return $this->table;
    }

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
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * {@inherit}
     */
    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;
        return $this;
    }

    /**
     * {@inherit}
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * {@inherit}
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * {@inherit}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inherit}
     */
    public function persist($entity)
    {
        if ($entity->isNew()) {
            $this->insert($entity);
        } else {
            $this->update($entity);
        }

        return $this;
    }

    /**
     * {@inherit}
     */
    public function find($id)
    {
        // TODO: Implement find() method.
    }

    /**
     * {@inherit}
     */
    public function findBy($criteria)
    {
        // TODO: Implement findBy() method.
    }

    /**
     * {@inherit}
     */
    public function countBy($criteria)
    {
        // TODO: Implement countBy() method.
    }

    /**
     * {@inherit}
     */
    public function delete($entity)
    {
        return $this;
    }

    /**
     * @param object $entity
     */
    protected function insert($entity)
    {
        $values = $entity->toArray();
        unset($values[$this->id]);

        $query = new InsertQuery();
        $query
            ->setTable($this->getTableFullName())
            ->setValues($values);

        $statement = $this->db->prepare($query->getSQL());
        $statement->execute($query->getParameters());

        $entity->set($this->id, $this->db->lastInsertId());
        $entity->unsetNew();
    }

    /**
     * @param object $entity
     */
    protected function update($entity)
    {
        $values = $entity->toArray();

        $query = new UpdateQuery();
        $query
            ->setTable($this->getTableFullName())
            ->setKeyName($this->id)
            ->setKeyValue($values[$this->id]);

        unset($values[$this->id]);

        $query->setValues($values);

        $statement = $this->db->prepare($query->getSQL());
        $statement->execute($query->getParameters());
    }

    /**
     * Return table full name
     * @return string
     */
    protected function getTableFullName()
    {
        return $this->db->prefix($this->prefix.'_'.$this->table);
    }
}
