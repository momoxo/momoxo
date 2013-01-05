<?php

namespace Xoops\Entity;

class GroupPermission
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $groupId;

    /**
     * @var int
     */
    private $itemId;

    /**
     * @var int
     */
    private $moduleId;

    /**
     * @var string
     */
    private $name;

    /**
     * Set group permission ID
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Return group permission ID
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set group ID
     * @param int $groupId
     * @return $this
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
        return $this;
    }

    /**
     * Return group ID
     * @return int
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * Set item ID
     * @param int $itemId
     * @return $this
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;
        return $this;
    }

    /**
     * Return item ID
     * @return int
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * Set module ID
     * @param int $moduleId
     * @return $this
     */
    public function setModuleId($moduleId)
    {
        $this->moduleId = $moduleId;
        return $this;
    }

    /**
     * Return module ID
     * @return int
     */
    public function getModuleId()
    {
        return $this->moduleId;
    }

    /**
     * Set group permission name
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Return group permission name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
