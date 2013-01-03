<?php

namespace Xoops\Entity;

use Xoops\Entity\PersistableInterface;

class TemplateSet implements PersistableInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $credits;

    /**
     * Created datetime: unix timestamp
     * @var int
     */
    private $createdAt;

    /**
     * Return ID
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set template set name
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Return template set name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set template set description
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Return template set description
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set template set credits
     * @param string $credits
     * @return $this
     */
    public function setCredits($credits)
    {
        $this->credits = $credits;
        return $this;
    }

    /**
     * Return template set credits
     * @return string
     */
    public function getCredits()
    {
        return $this->credits;
    }

    /**
     * Set created date time
     * @param int $createdAt Unix timestamp
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Return created date time
     * @return int Unix timestamp
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inherit}
     */
    public function importByPersistedObject(array $data)
    {
        $this->id          = $data['tplset_id'];
        $this->name        = $data['tplset_name'];
        $this->description = $data['tplset_desc'];
        $this->credits     = $data['tplset_credits'];
        $this->createdAt   = $data['tplset_created'];
        return $this;
    }

    /**
     * {@inherit}
     */
    public function exportForPersistence()
    {
        return array(
            'tplset_id'      => $this->id,
            'tplset_name'    => $this->name,
            'tplset_desc'    => $this->description,
            'tplset_credits' => $this->credits,
            'tplset_created' => $this->createdAt,
        );
    }
}
