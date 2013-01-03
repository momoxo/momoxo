<?php

namespace Xoops\Entity;

use Xoops\Entity\PersistableInterface;

class TemplateFile implements PersistableInterface
{
    const TYPE_BLOCK = 'block';
    const TYPE_MODULE = 'module';

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $referenceId;

    /**
     * @var string
     */
    private $templateSetName;

    /**
     * @var string
     */
    private $filename;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $modifiedAt;

    /**
     * @var int
     */
    private $importedAt;

    /**
     * @var string
     */
    private $moduleName;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $source;

    /**
     * Set template file ID
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Return template file ID
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set template file reference ID
     * @param int $referenceId
     * @return $this
     */
    public function setReferenceId($referenceId)
    {
        $this->referenceId = $referenceId;
        return $this;
    }

    /**
     * Return template file reference ID
     * @return int
     */
    public function getReferenceId()
    {
        return $this->referenceId;
    }

    /**
     * Set template set name
     * @param string $templateSetName
     * @return $this
     */
    public function setTemplateSetName($templateSetName)
    {
        $this->templateSetName = $templateSetName;
        return $this;
    }

    /**
     * Return template set name
     * @return string
     */
    public function getTemplateSetName()
    {
        return $this->templateSetName;
    }

    /**
     * Set template file name
     * @param string $filename
     * @return $this
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * Return template file name
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set template file description
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Return template file description
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set datetime modified at
     * @param int $modifiedAt Unix timestamp
     * @return $this
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;
        return $this;
    }

    /**
     * Return datetime modified at
     * @return int Unix timestamp
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * Set datetime imported at
     * @param int $importedAt Unix timestamp
     * @return $this
     */
    public function setImportedAt($importedAt)
    {
        $this->importedAt = $importedAt;
        return $this;
    }

    /**
     * Return datetime imported at
     * @return int Unix timestamp
     */
    public function getImportedAt()
    {
        return $this->importedAt;
    }

    /**
     * Set module name
     * @param string $moduleName
     * @return $this
     */
    public function setModuleName($moduleName)
    {
        $this->moduleName = $moduleName;
        return $this;
    }

    /**
     * Return module name
     * @return string
     */
    public function getModuleName()
    {
        return $this->moduleName;
    }

    /**
     * Set template file type
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Return template file type
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set template source code
     * @param string $source
     * @return $this
     */
    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }

    /**
     * Return template source code
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * {@inherit}
     */
    public function importByPersistedObject(array $data)
    {
        $this->id              = $data['tpl_id'];
        $this->referenceId     = $data['tpl_refid'];
        $this->templateSetName = $data['tpl_tplset'];
        $this->filename        = $data['tpl_file'];
        $this->description     = $data['tpl_desc'];
        $this->modifiedAt      = $data['tpl_lastmodified'];
        $this->importedAt      = $data['tpl_lastimported'];
        $this->moduleName      = $data['tpl_module'];
        $this->type            = $data['tpl_type'];
        $this->source          = $data['tpl_source'];

        return $this;
    }

    /**
     * {@inherit}
     */
    public function exportForPersistence()
    {
        return array(
            'tpl_id'           => $this->id,
            'tpl_refid'        => $this->referenceId,
            'tpl_tplset'       => $this->templateSetName,
            'tpl_file'         => $this->filename,
            'tpl_desc'         => $this->description,
            'tpl_lastmodified' => $this->modifiedAt,
            'tpl_lastimported' => $this->importedAt,
            'tpl_module'       => $this->moduleName,
            'tpl_type'         => $this->type,
            'tpl_source'       => $this->source,
        );
    }
}
