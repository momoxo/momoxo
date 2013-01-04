<?php

namespace Xoops\Entity;

use Xoops\Entity\PersistableInterface;

class ConfigItem implements PersistableInterface
{
    const FORM_TYPE_TEXTAREA = 'textarea';
    const FORM_TYPE_SELECT = 'select';
    const FORM_TYPE_RADIO = 'radio';
    const FORM_TYPE_SELECT_MULTI = 'select_multi';
    const FORM_TYPE_CHECKBOX = 'checkbox';
    const FORM_TYPE_YES_NO = 'yesno';
    const FORM_TYPE_THEME = 'theme';
    const FORM_TYPE_THEME_MULTI = 'theme_multi';
    const FORM_TYPE_TEMPLATE_SET = 'tplset';
    const FORM_TYPE_TIMEZONE = 'timezone';
    const FORM_TYPE_LANGUAGE = 'language';
    const FORM_TYPE_START_PAGE = 'startpage';
    const FORM_TYPE_GROUP = 'group';
    const FORM_TYPE_GROUP_MULTI = 'group_multi';
    const FORM_TYPE_GROUP_CHECKBOX = 'group_checkbox';
    const FORM_TYPE_USER = 'user';
    const FORM_TYPE_USER_MULTI = 'user_multi';
    const FORM_TYPE_MODULE_CACHE = 'module_cache';
    const FORM_TYPE_PASSWORD = 'password';
    const FORM_TYPE_TEXTBOX = 'textbox';
    const FORM_TYPE_TEXT = 'text';

    const VALUE_TYPE_INT = 'int';
    const VALUE_TYPE_FLOAT = 'float';
    const VALUE_TYPE_ARRAY = 'array';
    const VALUE_TYPE_TEXT = 'text';

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $moduleId;

    /**
     * @var int
     */
    private $categoryId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $formType;

    /**
     * @var string
     */
    private $valueType;

    /**
     * @var int
     */
    private $order;

    /**
     * {@inherit}
     */
    public function importByPersistedObject(array $data)
    {
        $this->id = $data['conf_id'];
        $this->moduleId = $data['conf_modid'];
        $this->categoryId = $data['conf_catid'];
        $this->name = $data['conf_name'];
        $this->title = $data['conf_title'];
        $this->value = $data['conf_value'];
        $this->description = $data['conf_desc'];
        $this->formType = $data['conf_formtype'];
        $this->valueType = $data['conf_valuetype'];
        $this->order = $data['conf_order'];

        return $this;
    }

    /**
     * {@inherit}
     */
    public function exportForPersistence()
    {
        return array(
            'conf_id'        => $this->id,
            'conf_modid'     => $this->moduleId,
            'conf_catid'     => $this->categoryId,
            'conf_name'      => $this->name,
            'conf_title'     => $this->title,
            'conf_value'     => $this->value,
            'conf_desc'      => $this->description,
            'conf_formtype'  => $this->formType,
            'conf_valuetype' => $this->valueType,
            'conf_order'     => $this->order,
        );
    }

    /**
     * Set config item ID
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Return config item ID
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * Set config category ID
     * @param int $categoryId
     * @return $this
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
        return $this;
    }

    /**
     * Return config category ID
     * @return int
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set config name
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Return config name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set config title
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Return config title
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set config value
     * @param string $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Return config value
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set config description
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Return config description
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set config form type
     * @param string $formType
     * @return $this
     */
    public function setFormType($formType)
    {
        $this->formType = $formType;
        return $this;
    }

    /**
     * Return config form type
     * @return string
     */
    public function getFormType()
    {
        return $this->formType;
    }

    /**
     * Set config value type
     * @param string $valueType
     * @return $this
     */
    public function setValueType($valueType)
    {
        $this->valueType = $valueType;
        return $this;
    }

    /**
     * Return config value type
     * @return string
     */
    public function getValueType()
    {
        return $this->valueType;
    }

    /**
     * Set config order
     * @param int $order
     * @return $this
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * Return config order
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }
}
