<?php

namespace Xoops\Entity;

class Group
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
    private $type;

    /**
     * Set group ID
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Return group ID
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set group name
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Return group name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set group description
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Return group description
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set group type
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Return group type
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
