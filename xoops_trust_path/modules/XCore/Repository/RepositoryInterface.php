<?php

namespace XCore\Repository;

use Exception;
use XCore\Database\DatabaseInterface;

interface RepositoryInterface
{
    /**
     * Return new Repository instance
     * @param DatabaseInterface $db
     */
    public function __construct(DatabaseInterface $db);

    /**
     * Persist an entity
     * @param object $entity
     * @return $this
     * @throws Exception when failed to persist the entity
     */
    public function persist($entity);

    /**
     * Find by an entity by identifier
     * @param string $id
     * @return object
     * @throws Exception when failed to find
     */
    public function find($id);

    /**
     * Find entities by the criteria
     * @param object $criteria
     * @return object[]
     * @throws Exception when failed to find
     */
    public function findBy($criteria);

    /**
     * Count entities matches the criteria
     * @param object $criteria
     * @return int
     * @throws Exception when failed to count
     */
    public function countBy($criteria);

    /**
     * Delete an entity from persistence storage
     * @param object $entity
     * @return $this
     * @throws Exception when failed to delete the entity
     */
    public function delete($entity);
}
