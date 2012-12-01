<?php

/**
 * This is a target whom a render-system renders. This has a buffer and receives
 * a result of a render-system to the buffer. A developer can control rendering
 * with using this class.
 */
class XCube_RenderTarget
{
	var $mName = null;

	var $mRenderBuffer = null;
	
	var $mModuleName = null;
	
	var $mTemplateName = null;

	var $mAttributes = array();
	
	/**
	 * @deprecated
	 */
	var $mType = XCUBE_RENDER_TARGET_TYPE_BUFFER;
	
	var $mCacheTime = null;
		
	function __construct()
	{
	}

	function setName($name)
	{
		$this->mName = $name;
	}

	function getName()
	{
		return $this->mName;
	}
	
	function setTemplateName($name)
	{
		$this->mTemplateName = $name;
	}

	function getTemplateName()
	{
		return $this->mTemplateName;
	}
	
	function setAttribute($key,$value)
	{
		$this->mAttributes[$key] = $value;
	}
	
	function setAttributes($attr)
	{
		$this->mAttributes = $attr;
	}
	
	function getAttribute($key)
	{
		return isset($this->mAttributes[$key]) ? $this->mAttributes[$key] : null;
	}

	function getAttributes()
	{
		return $this->mAttributes;
	}
	
	/**
	 * Set render-target type.
	 * @param $type int Use constants that are defined by us.
	 * @deprecated
	 */
	function setType($type)
	{
		$this->mType = $type;
		$this->setAttribute('xcore_buffertype', $type);
	}
	
	/**
	 * Return render-target type.
	 * @return int
	 * @deprecated
	 */
	function getType()
	{
		return $this->getAttribute('xcore_buffertype', $type);
		//return $this->mType;
	}
	
	function setResult(&$result)
	{
		$this->mRenderBuffer = $result;
	}
	
	function getResult()
	{
		return $this->mRenderBuffer;
	}
	
	/**
	 * Reset a template name and attributes in own properties.
	 */
	function reset()
	{
		$this->setTemplateName(null);
		unset($this->mAttributes);
		$this->mAttributes = array();
		$this->mRenderBuffer = null;
	}
}
