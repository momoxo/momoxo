<?php

/**
 * The structure which have a policy and an information of a module, which
 * Xcore_Controller must know. In the later version, this class may be
 * replaced with just array.
 * 
 * For a performance, this class has reset() to reuse a object.
 */
class Xcore_AbstractCacheInformation
{
    /**
     * Array of uid. This is an information for cache store program to generate
     * an unique file name. Uid isn't must. Sets identity data.
     * 
     * @access public
     * @var Array of uid
     */
    var $mIdentityArr = array();
    
    /**
     * Array of groupid. This is an information for cache store program to
     * generate an unique file name.
     * 
     * @access public
     * @var Array of groupid
     */
    var $mGroupArr = array();

    /**
     * Boolean flag indicating whether this object asks caching to the
     * controller.
     * 
     * @access private
     * @var bool
     */ 
    var $_mEnableCache = false;
    
    /**
     * For a special cache mechanism, free to use hashmap.
     * 
     * @access public
     * @var array
     */
    var $mAttributes = array();
    
    function __construct()
    {
    }
    
    /**
     * Gets a value indicating whether someone has tried to set a flag to this
     * object.
     * @return bool
     */
    function hasSetEnable()
    {
        return $this->_mEnableCache !== false;
    }
    
    /**
     * Sets a flag indicating whether this object decides executing cache.
     * @param bool $flag
     */
    function setEnableCache($flag)
    {
        $this->_mEnableCache = $flag;
    }
    
    /**
     * Gets a flag indicating whether this object decides executing cache.
     * @return bool
     */
    function isEnableCache()
    {
        return $this->_mEnableCache;
    }
    
    /**
     * Resets member properties to reuse this object.
     */
    function reset()
    {
        $this->mIdentityArr = array();
        $this->mGroupArr = array();
        $this->_mEnableCache = null;
    }
    
    function getCacheFilePath()
    {
    }
}
