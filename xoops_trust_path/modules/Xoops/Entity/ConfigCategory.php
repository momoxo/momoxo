<?php

namespace Xoops\Entity;

use Xoops\Entity\PersistableInterface;

class ConfigCategory implements PersistableInterface
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
     * @var int
     */
    private $order;

    /**
     * {@inherit}
     */
    public function importByPersistedObject(array $data)
    {
        $this->id    = $data['confcat_id'];
        $this->name  = $data['confcat_name'];
        $this->order = $data['confcat_order'];

        return $this;
    }

    /**
     * {@inherit}
     */
    public function exportForPersistence()
    {
        return array(
            'confcat_id'    => $this->id,
            'confcat_name'  => $this->name,
            'confcat_order' => $this->order,
        );
    }

    /**
     * Set config category ID
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Return config category ID
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set config category name
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Return config category name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set config category order
     * @param int $order
     * @return $this
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * Return config category order
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }
}
