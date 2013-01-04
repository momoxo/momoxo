<?php

namespace Xoops\Entity;

use Xoops\Entity\PersistableInterface;

class Block implements PersistableInterface
{
    const SIDE_LEFT          = 0;
    const SIDE_RIGHT         = 1;
    const SIDE_CENTER_LEFT   = 3;
    const SIDE_CENTER_RIGHT  = 4;
    const SIDE_CENTER_CENTER = 5;

    const BLOCK_TYPE_MODULE = 'M';
    const BLOCK_TYPE_CUSTOM = 'C';

    const CONTENT_TYPE_HTML   = 'H';
    const CONTENT_TYPE_PHP    = 'P';
    const CONTENT_TYPE_SMILEY = 'S';
    const CONTENT_TYPE_TEXT   = 'T';

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $moduleId = 0;

    /**
     * @var int
     */
    private $functionNumber = 0;

    /**
     * @var string[]
     */
    private $options = array();

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
    private $content;

    /**
     * @var int
     */
    private $side = 0;

    /**
     * @var int
     */
    private $weight = 0;

    /**
     * @var bool
     */
    private $isVisible = false;

    /**
     * @var string
     */
    private $blockType;

    /**
     * @var string
     */
    private $contentType;

    /**
     * @var bool
     */
    private $isActive = false;

    /**
     * @var string
     */
    private $dirname;

    /**
     * @var string
     */
    private $functionFilename;

    /**
     * @var string
     */
    private $showFunctionName;

    /**
     * @var string
     */
    private $editFunctionName;

    /**
     * @var string
     */
    private $templateFilename;

    /**
     * @var int
     */
    private $cacheTime = 0;

    /**
     * @var int
     */
    private $modifiedAt;

    /**
     * Return new Block entity
     */
    public function __construct()
    {
        $this->modifiedAt = time();
    }

    /**
     * {@inherit}
     */
    public function importByPersistedObject(array $data)
    {
        $this->id = $data['bid'];
        $this->moduleId = $data['mid'];
        $this->functionNumber = $data['func_num'];
        $this->options = explode('|', $data['options']);
        $this->name = $data['name'];
        $this->title = $data['title'];
        $this->content = $data['content'];
        $this->side = $data['side'];
        $this->weight = $data['weight'];
        $this->isVisible = (bool) $data['visible'];
        $this->blockType = $data['block_type'];
        $this->contentType = $data['c_type'];
        $this->isActive = (bool) $data['isactive'];
        $this->dirname = $data['dirname'];
        $this->functionFilename = $data['func_file'];
        $this->showFunctionName = $data['show_func'];
        $this->editFunctionName = $data['edit_func'];
        $this->templateFilename = $data['template'];
        $this->cacheTime = $data['bcachetime'];
        $this->modifiedAt = $data['last_modified'];

        return $this;
    }

    /**
     * {@inherit}
     */
    public function exportForPersistence()
    {
        return array(
            'bid'           => $this->id,
            'mid'           => $this->moduleId,
            'func_num'      => $this->functionNumber,
            'options'       => implode('|', $this->options),
            'name'          => $this->name,
            'title'         => $this->title,
            'content'       => $this->content,
            'side'          => $this->side,
            'weight'        => $this->weight,
            'visible'       => (int) $this->isVisible,
            'block_type'    => $this->blockType,
            'c_type'        => $this->contentType,
            'isactive'      => (int) $this->isActive,
            'dirname'       => $this->dirname,
            'func_file'     => $this->functionFilename,
            'show_func'     => $this->showFunctionName,
            'edit_func'     => $this->editFunctionName,
            'template'      => $this->templateFilename,
            'bcachetime'    => $this->cacheTime,
            'last_modified' => $this->modifiedAt,
        );
    }

    /**
     * Set block ID
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Return block ID
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
     * Set block function number
     * @param int $functionNumber
     * @return $this
     */
    public function setFunctionNumber($functionNumber)
    {
        $this->functionNumber = $functionNumber;
        return $this;
    }

    /**
     * Return block function number
     * @return int
     */
    public function getFunctionNumber()
    {
        return $this->functionNumber;
    }

    /**
     * Set block options
     * @param string[] $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * Return block options
     * @return string[]
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set block name
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Return block name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set block title
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Return block title
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set block content
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Return block content
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set block side
     * @param int $side
     * @return $this
     */
    public function setSide($side)
    {
        $this->side = $side;
        return $this;
    }

    /**
     * Return block side
     * @return int
     */
    public function getSide()
    {
        return $this->side;
    }

    /**
     * Set block weight
     * @param int $weight
     * @return $this
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * Return block weight
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Determine if the block is visible
     * @return bool
     */
    public function isVisible()
    {
        return $this->isVisible;
    }

    /**
     * Show the block
     * @return $this
     */
    public function show()
    {
        $this->isVisible = true;
        return $this;
    }

    /**
     * Hide the block
     * @return $this
     */
    public function hide()
    {
        $this->isVisible = false;
        return $this;
    }

    /**
     * Set block type
     * @param string $blockType
     * @return $this
     */
    public function setBlockType($blockType)
    {
        $this->blockType = $blockType;
        return $this;
    }

    /**
     * Return block type
     * @return string
     */
    public function getBlockType()
    {
        return $this->blockType;
    }

    /**
     * Set block content type
     * @param string $contentType
     * @return $this
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        return $this;
    }

    /**
     * Return block content type
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Determine if this block is active
     * @return bool
     */
    public function isActive()
    {
        return $this->isActive;
    }

    /**
     * Activate this block
     * @return $this
     */
    public function activate()
    {
        $this->isActive = true;
        return $this;
    }

    /**
     * Inactivate this block
     * @return $this
     */
    public function inactivate()
    {
        $this->isActive = false;
        return $this;
    }

    /**
     * Set block dirname
     * @param string $dirname
     * @return $this
     */
    public function setDirname($dirname)
    {
        $this->dirname = $dirname;
        return $this;
    }

    /**
     * Return block dirname
     * @return string
     */
    public function getDirname()
    {
        return $this->dirname;
    }

    /**
     * Set block function filename
     * @param string $functionFilename
     * @return $this
     */
    public function setFunctionFilename($functionFilename)
    {
        $this->functionFilename = $functionFilename;
        return $this;
    }

    /**
     * Return block function filename
     * @return string
     */
    public function getFunctionFilename()
    {
        return $this->functionFilename;
    }

    /**
     * Set block show function name
     * @param string $showFunctionName
     * @return $this
     */
    public function setShowFunctionName($showFunctionName)
    {
        $this->showFunctionName = $showFunctionName;
        return $this;
    }

    /**
     * Return block show function name
     * @return string
     */
    public function getShowFunctionName()
    {
        return $this->showFunctionName;
    }

    /**
     * Set block edit function name
     * @param string $editFunctionName
     * @return $this
     */
    public function setEditFunctionName($editFunctionName)
    {
        $this->editFunctionName = $editFunctionName;
        return $this;
    }

    /**
     * Return block edit function name
     * @return string
     */
    public function getEditFunctionName()
    {
        return $this->editFunctionName;
    }

    /**
     * Set block template filename
     * @param string $templateFilename
     * @return $this
     */
    public function setTemplateFilename($templateFilename)
    {
        $this->templateFilename = $templateFilename;
        return $this;
    }

    /**
     * Return block template filename
     * @return string
     */
    public function getTemplateFilename()
    {
        return $this->templateFilename;
    }

    /**
     * Set block cache time
     * @param int $cacheTime
     * @return $this
     */
    public function setCacheTime($cacheTime)
    {
        $this->cacheTime = $cacheTime;
        return $this;
    }

    /**
     * Return block cache time
     * @return int
     */
    public function getCacheTime()
    {
        return $this->cacheTime;
    }

    /**
     * Set datetime at which block modified
     * @param int $modifiedAt
     * @return $this
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;
        return $this;
    }

    /**
     * Return datetime at which block modified
     * @return int
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }
}
