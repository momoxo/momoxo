<?php

namespace Xoops\Entity;

/**
 * Persistable entity interface
 */
interface PersistableInterface
{
    /**
     * Import by persisted object
     * @param array $data Persisted object
     * @return $this
     */
    public function importByPersistedObject(array $data);

    /**
     * Export for persistence
     * @return array
     */
    public function exportForPersistence();
}
