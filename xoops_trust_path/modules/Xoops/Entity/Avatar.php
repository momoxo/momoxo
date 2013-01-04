<?php

namespace Xoops\Entity;

use Xoops\Entity\PersistableInterface;

class Avatar implements PersistableInterface
{
    const TYPE_SYSTEM = 'S';
    const TYPE_CUSTOM = 'C';

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $filename;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $mimeType;

    /**
     * @var int
     */
    private $createdAt;

    /**
     * @var bool
     */
    private $isDisplayed = true;

    /**
     * @var int
     */
    private $weight = 0;

    /**
     * @var string
     */
    private $type;

    /**
     * {@inherit}
     */
    public function importByPersistedObject(array $data)
    {
        $this->id          = $data['avatar_id'];
        $this->filename    = $data['avatar_file'];
        $this->name        = $data['avatar_name'];
        $this->mimeType    = $data['avatar_mimetype'];
        $this->createdAt   = $data['avatar_created'];
        $this->isDisplayed = (bool) $data['avatar_display'];
        $this->weight      = $data['avatar_weight'];
        $this->type        = $data['avatar_type'];

        return $this;
    }

    /**
     * {@inherit}
     */
    public function exportForPersistence()
    {
        return array(
            'avatar_id'       => $this->id,
            'avatar_file'     => $this->filename,
            'avatar_name'     => $this->name,
            'avatar_mimetype' => $this->mimeType,
            'avatar_created'  => $this->createdAt,
            'avatar_display'  => (int) $this->isDisplayed,
            'avatar_weight'   => $this->weight,
            'avatar_type'     => $this->type,
        );
    }

    /**
     * Set avatar ID
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Return avatar ID
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set avatar filename
     * @param string $filename
     * @return $this
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * Return avatar filename
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set avatar name
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Return avatar name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set avatar mime type
     * @param string $mimeType
     * @return $this
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
        return $this;
    }

    /**
     * Return avatar mime type
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set datetime at which avatar created
     * @param int $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Return datetime at which avatar created
     * @return int
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Determine if the avatar is displayed
     * @return bool
     */
    public function isDisplayed()
    {
        return $this->isDisplayed;
    }

    /**
     * Hide avatar
     * @return $this
     */
    public function hide()
    {
        $this->isDisplayed = false;
        return $this;
    }

    /**
     * Display avatar
     * @return $this
     */
    public function display()
    {
        $this->isDisplayed = true;
        return $this;
    }

    /**
     * Set avatar weight
     * @param int $weight
     * @return $this
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * Return avatar weight
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set avatar type
     * @param string $type self::TYPE_SYSTEM or self::TYPE_CUSTOM
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Return avatar type
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
