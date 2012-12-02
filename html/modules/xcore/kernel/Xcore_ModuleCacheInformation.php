<?php

use XCore\Kernel\Ref;
use XCore\Kernel\Delegate;

class Xcore_ModuleCacheInformation extends Xcore_AbstractCacheInformation
{
    /**
     * [READ ONLY] Xoops Module Object.
     * 
     * @access protected
     * @var XoopsModule
     */
    var $mModule = null;
    
    /**
     * The current URL used as a base for a cache file name. This should be
     * modified by modules to not make extra cache files.
     * 
     * @access public
     * @var string
     */
    var $mURL = null;

     /**
      * @var Delegate
      */
     var $mGetCacheFilePath = null;
     
     function Xcore_ModuleCacheInformation()
     {
         parent::Xcore_AbstractCacheInformation();
         $this->mGetCacheFilePath = new Delegate();
         $this->mGetCacheFilePath->register('Xcore_ModuleCacheInformation.GetCacheFilePath');
     }
     
    /**
     * Sets a module object.
     * @param XoopsModule $module
     */
    function setModule(&$module)
    {
        $this->mModule =& $module;
    }
    
    function reset()
    {
        parent::reset();
        $this->mModule = null;
        $this->mURL = null;
    }
    
    /**
     * Gets a file path of a cache file for module contents.
     * @param Xcore_ModuleCacheInformation $cacheInfo
     * @return string
     */
    function getCacheFilePath()
    {
        $filepath = null;
        $this->mGetCacheFilePath->call(new Ref($filepath), $this);
        
        if (!$filepath) {
            $id = md5(XOOPS_SALT . $this->mURL . "(" . implode("_", $this->mIdentityArr) . ")" . implode("_", $this->mGroupArr));
            $filepath = XOOPS_CACHE_PATH . "/" . $id . ".cache.html";
        }
        
        return $filepath;
    }
}
