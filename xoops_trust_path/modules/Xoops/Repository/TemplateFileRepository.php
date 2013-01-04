<?php

namespace Xoops\Repository;

use Xoops\Database\DatabaseInterface;
use Xoops\Entity\TemplateFile;
use XCore\Database\InsertQuery;
use XCore\Database\UpdateQuery;

class TemplateFileRepository
{
    /**
     * @var DatabaseInterface
     */
    private $db;

    /**
     * @var string
     */
    private $templateFileTable;

    /**
     * @var string
     */
    private $templateSourceTable;

    /**
     * @param DatabaseInterface $db
     */
    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
        $this->templateFileTable = $this->db->prefix('tplfile');
        $this->templateSourceTable = $this->db->prefix('tplsource');
    }

    /**
     * Persist TemplateFile entity
     * @param TemplateFile $templateFile
     */
    public function persist(TemplateFile $templateFile)
    {
        if ($templateFile->getId() === null) {
            $this->insert($templateFile);
        } else {
            $this->update($templateFile);
        }
    }

    /**
     * Find TemplateFile entity by ID
     * @param int $id
     * @return TemplateFile|null When entity is not found, returns NULL
     */
    public function find($id)
    {
        $templateFileTable = $this->templateFileTable;
        $templateSourceTable = $this->templateSourceTable;

        $select = "SELECT f.*, s.tpl_source FROM $templateFileTable AS f ".
            "INNER JOIN $templateSourceTable AS s ON f.tpl_id = s.tpl_id ".
            "WHERE f.tpl_id = :tpl_id";
        $statement = $this->db->prepare($select);
        $statement->execute(array(':tpl_id' => $id));

        $row = $statement->fetch();

        if ($row === false) {
            return null;
        }

        $templateFile = new TemplateFile();
        $templateFile->importByPersistedObject($row);

        return $templateFile;
    }

    /**
     * Delete TemplateFile entity from database
     * @param TemplateFile $templateFile
     */
    public function delete(TemplateFile $templateFile)
    {
        $delete = "DELETE FROM {$this->templateSourceTable} WHERE tpl_id = :tpl_id";
        $statement = $this->db->prepare($delete);
        $statement->execute(array(':tpl_id' => $templateFile->getId()));

        $delete = "DELETE FROM {$this->templateFileTable} WHERE tpl_id = :tpl_id";
        $statement = $this->db->prepare($delete);
        $statement->execute(array(':tpl_id' => $templateFile->getId()));
    }

    private function update(TemplateFile $templateFile)
    {
        $data = $templateFile->exportForPersistence();
        unset($data['tpl_source']);

        // update template_file table
        $updateQuery = new UpdateQuery();
        $updateQuery
            ->setTable($this->templateFileTable)
            ->setValues($data)
            ->setKeyName('tpl_id')
            ->setKeyValue($data['tpl_id']);

        $statement = $this->db->prepare($updateQuery->getSQL());
        $statement->execute($updateQuery->getParameters());

        // update template_source table
        $updateQuery = new UpdateQuery();
        $updateQuery
            ->setTable($this->templateSourceTable)
            ->setKeyName('tpl_id')
            ->setKeyValue($data['tpl_id'])
            ->setValues(
                array(
                    'tpl_source' => $templateFile->getSource(),
                )
            );

        $statement = $this->db->prepare($updateQuery->getSQL());
        $statement->execute($updateQuery->getParameters());
    }

    private function insert(TemplateFile $templateFile)
    {
        $data = $templateFile->exportForPersistence();
        unset($data['tpl_source']);

        // Insert to template_file table
        $insertQuery = new InsertQuery();
        $insertQuery
            ->setTable($this->templateFileTable)
            ->setValues($data);

        $statement = $this->db->prepare($insertQuery->getSQL());
        $statement->execute($insertQuery->getParameters());

        $templateFile->setId($this->db->lastInsertId());

        // Insert to template_source table
        $insertQuery = new InsertQuery();
        $insertQuery
            ->setTable($this->templateSourceTable)
            ->setValues(
                array(
                    'tpl_id'     => $templateFile->getId(),
                    'tpl_source' => $templateFile->getSource(),
                )
            );

        $statement = $this->db->prepare($insertQuery->getSQL());
        $statement->execute($insertQuery->getParameters());
    }
}
