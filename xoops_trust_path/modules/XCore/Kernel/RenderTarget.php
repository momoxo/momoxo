<?php

namespace XCore\Kernel;

/**
 * This is a target whom a render-system renders. This has a buffer and receives
 * a result of a render-system to the buffer. A developer can control rendering
 * with using this class.
 */
class RenderTarget
{
    /**
     * @var string
     */
    protected $mName;

    /**
     * @var string
     */
    protected $mRenderBuffer;

    /**
     * @var string
     */
    protected $mModuleName;

    /**
     * @var string
     */
    protected $mTemplateName;

    /**
     * @var array
     */
    protected $mAttributes = array();

    /**
     * @deprecated
     */
    protected $mType = XCUBE_RENDER_TARGET_TYPE_BUFFER;

    /**
     * @var null
     */
    protected $mCacheTime = null;

    /**
     * Return new RenderTarget instance
     */
    public function __construct()
    {
    }

    /**
     * @param $name
     * @return void
     */
    public function setName($name)
    {
        $this->mName = $name;
    }

    /**
     * @return null
     */
    public function getName()
    {
        return $this->mName;
    }

    /**
     * @param  string $name
     * @return void
     */
    public function setTemplateName($name)
    {
        $this->mTemplateName = $name;
    }

    /**
     * @return string
     */
    public function getTemplateName()
    {
        return $this->mTemplateName;
    }

    /**
     * @param  string $key
     * @param  mixed  $value
     * @return void
     */
    public function setAttribute($key, $value)
    {
        $this->mAttributes[$key] = $value;
    }

    /**
     * @param  array $attr
     * @return void
     */
    public function setAttributes($attr)
    {
        $this->mAttributes = $attr;
    }

    /**
     * @param  string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        return isset($this->mAttributes[$key]) ? $this->mAttributes[$key] : null;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->mAttributes;
    }

    /**
     * Set render-target type.
     * @param $type int Use constants that are defined by us.
     * @deprecated
     */
    public function setType($type)
    {
        $this->mType = $type;
        $this->setAttribute('xcore_buffertype', $type);
    }

    /**
     * Return render-target type.
     * @return int
     * @deprecated
     */
    public function getType()
    {
        return $this->getAttribute('xcore_buffertype');
        //return $this->mType;
    }

    /**
     * @param  string $result
     * @return void
     */
    public function setResult(&$result)
    {
        $this->mRenderBuffer = $result;
    }

    /**
     * @return string
     */
    public function getResult()
    {
        return $this->mRenderBuffer;
    }

    /**
     * Reset a template name and attributes in own properties.
     * @return void
     */
    public function reset()
    {
        $this->setTemplateName(null);
        unset($this->mAttributes);
        $this->mAttributes = array();
        $this->mRenderBuffer = null;
    }
}
