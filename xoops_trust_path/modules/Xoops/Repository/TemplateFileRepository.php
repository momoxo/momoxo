<?php

namespace Xoops\Repository;

use Xoops\Database\DatabaseInterface;
use Xoops\Entity\TemplateFile;

class TemplateFileRepository
{
    /**
     * @var DatabaseInterface
     */
    private $db;

    /**
     * @param DatabaseInterface $db
     */
    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }

    public function persist(TemplateFile $templateFile)
    {

    }

    public function find($id)
    {

    }
}
