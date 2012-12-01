<?php

/**
  * @public
  * @brief [Abstract] Represents modules and used for Xcore_Controller
  * 
  * This is an abstract class which has interfaces to connect with the controller about
  * the module process. Legacy controller makes an interface of this class and uses its
  * methods to call module programs.
  * 
  * So modules may define their sub-classes implementing this interface.
  * The instance is attached to the Xcore_Context after initializing, so modules can
  * defines members for module's features and can access them. But, most interfaces
  * defined by this class should be called by only Xcore_Controller.
  * 
  * @attention
  *    This interfaces are initialized by only Xcore_Controller.
  * 
  * @see Xcore_Utils::createModule()
  * @see XoopsModule
  */
use XCore\Kernel\Root;

class Xcore_AbstractModule
{
    /**
     * @public
     * @brief [READ ONLY] Map Array - std::map<string, mixed> - used freely for this module.
     * @remarks
     *    If references are must, access directly to this member.
     */
    var $mAttributes = array();
    
    /**
     * @public
     * @brief [READ ONLY] XoopsModule
     */
    var $mXoopsModule = null;
    
    /**
     * @public
     * @brief [READ ONLY] Map Array - std::map<string, string>
     */
    var $mModuleConfig = array();
    
    /**
     * @private
     * @brief Xcore_AbstractCacheInformation - The cached instance.
     * @see getCacheInfo()
     */
    var $mCacheInfo = null;
    
    /**
     * @private
     * @brief XCube_RenderTarget - The render target instance for this module.
     * @see getRenderTarget()
     */
    var $mRender = null;
    
    /**
     * @public
     * @brief constructor
     * @param $module XoopsModule
     * @attention
     *     Basically, only Xcore_Controller and its utility functions should call the
     *     constructor.
     */
    function Xcore_AbstractModule(&$module, $loadConfig=true)
    {
        $this->setXoopsModule($module);
        
        if ($loadConfig && ($module->get('hasconfig') == 1 || $module->get('hascomments') == 1 || $module->get('hasnotification') == 1)) {
            $handler =& xoops_gethandler('config');
            $this->setModuleConfig($handler->getConfigsByCat(0, $module->get('mid')));
        }
    }

    /**
     * @public
     * @brief Sets $value with $key to attributes.
     * @param $key string
     * @param $value mixed
     * @return void
     * @remarks
     *    If references are must, access directly to $mAttributes. Because PHP4 can't
     *    handle reference in the signature of this member function.
     */
    function setAttribute($key, $value)
    {
        $this->mAttributes[$key] = $value;
    }

    /**
     * @public
     * @brief Gets a value indicating whether the value specified by $key exists.
     * @param $key string
     * @return bool
     */ 
    function hasAttribute($key)
    {
        return isset($this->mAttributes[$key]);
    }
    
    /**
     * @public
     * @brief Gets a value of attributes with $key.
     * @param string $key
     * @return mixed - If the value specified by $key doesn't exist in attributes, returns null.
     */
    function getAttribute($key)
    {
        return isset($this->mAttributes[$key]) ? $this->mAttributes[$key] : null;
    }

    /**
     * @public
     * @brief Binds an instance of XoopsModule to the property.
     * @param $xoopsModule XoopsModule
     * @return void
     */ 
    function setXoopsModule(&$xoopsModule)
    {
        $this->mXoopsModule =& $xoopsModule;
    }
    
    /**
     * @public
     * @brief Gets the binded XoopsModule instance.
     * @return XoopsModule
     */
    function &getXoopsModule()
    {
        return $this->mXoopsModule;
    }
    
    /**
     * @public
     * @brief Binds array of xoops module config to the property.
     * @param $config Map Array - std::map<string, mixed>
     * @return void 
     */
    function setModuleConfig($config)
    {
        $this->mModuleConfig = $config;
    }

    /**
     * @public
     * @brief Gets a value form xoops module config with $key. 
     * @param $key string
     * @return mixed If $key is specified null, returns map array (std::map<string, mixed>)
     */
    function getModuleConfig($key = null)
    {
        if ($key == null) {
            return $this->mModuleConfig;
        }
        
        return isset($this->mModuleConfig[$key]) ? $this->mModuleConfig[$key] : null;
    }

    /**
     * @public
     * @brief Gets the cache information instance.
     * @return Xcore_ModuleCaceInformation
     * @see _createChaceInfo()
     */ 
    function &getCacheInfo()
    {
        if (!is_object($this->mCacheInfo)) {
            $this->_createCacheInfo();
        }
        
        return $this->mCacheInfo;
    }
    
    /**
     * @protected
     * @brief Creates a cache information instance and returns it.
     * @return Xcore_ModuleCacheInformation
     * @remarks
     *     This member function sets the created instance to mCacheInfo because this
     *     instance has to keep the instance for many callbacks.
     * @see getCacheInfo()
     */
    function _createCacheInfo()
    {
        $this->mCacheInfo = new Xcore_ModuleCacheInformation();
        $this->mCacheInfo->mURL = xoops_getenv('REQUEST_URI');
        $this->mCacheInfo->setModule($this->mXoopsModule);
    }
    
    /**
     * @public
     * @brief Gets the render target instance.
     * @return XCube_RenderTarget
     * @see _createRenderTarget()
     */
    function &getRenderTarget()
    {
        if ($this->mRender == null) {
            $this->_createRenderTarget();
        }
        
        return $this->mRender;
    }

    /**
     * @protected
     * @brief Creates a render target instance and returns it.
     * @return XCube_RenderTarget
     * @remarks
     *     This member function sets the created instance to mRender because this
     *     instance has to keep the instance for many callbacks.
     * @see getRenderTarget()
     */ 
    function _createRenderTarget()
    {
        $renderSystem =& $this->getRenderSystem();
        
        $this->mRender =& $renderSystem->createRenderTarget('main');
        if ($this->mXoopsModule != null) {
            $this->mRender->setAttribute('xcore_module', $this->mXoopsModule->get('dirname'));
        }
    }
    
    /**
     * @public
     * @brief Gets a name of the dependency render system.
     * @return string
     * @remarks
     *     If this module depends on other systems than the main render system  by Xcore,
     *     override this.
     * @see getRenderSystem()
     */
    function getRenderSystemName()
    {
        $root =& Root::getSingleton();
        return $root->mContext->mBaseRenderSystemName;
    }
    
    /**
     * @public
     * @brief Gets the dependency render system.
     * @return XCube_RenderSystem
     * @remarks
     *     If this module uses the unregistered render system is used, override this.
     */
    function &getRenderSystem()
    {
        $root =& Root::getSingleton();
        $renderSystem =& $root->getRenderSystem($this->getRenderSystemName());
        
        return $renderSystem;
    }
    
    /**
     * @public
     * @brief Gets a value indicating whether this modules is an active.
     * @return bool
     */
    function isActive()
    {
        if (!is_object($this->mXoopsModule)) {  //< FIXME
            return false;
        }
        
        return $this->mXoopsModule->get('isactive') ? true : false;
    }
    
    /**
     * @public
     * @brief Gets a value indicating whether the current module has a option of
     *        configurations to use the cache system.
     * @return bool
     */
    function isEnableCache()
    {
        if (xoops_getenv('REQUEST_METHOD') == 'POST') {
            return false;
        }
        
        $root =& Root::getSingleton();
        
        return is_object($this->mXoopsModule) && !empty($root->mContext->mXoopsConfig['module_cache'][$this->mXoopsModule->get('mid')]);
    }
    
    /**
     * @public
     * @brief Initializes a cache information object, and returns it.
     * @return Xcore_ModuleCacheInformation
     */
    function &createCacheInfo()
    {
        $this->mCacheInfo = new Xcore_ModuleCacheInformation();
        $this->mCacheInfo->mURL = xoops_getenv('REQUEST_URI');
        $this->mCacheInfo->setModule($this->mXoopsModule);
        
        return $this->mCacheInfo;
    }

    /**
     * @public
     * @brief [Abstract] This method is called by the controller strategy, if this module
     *        is the current module.
     * @return void
     */ 
    function startup()
    {
    }
    
    /**
     * @public
     * @brief [Abstract] This method is called back by the action search feature in the
     *        control panel.
     * @param Xcore_ActionSearchArgs $searchArgs
     * @return void
     * @see Xcore_ActionSearchArgs
     */
    function doActionSearch(&$searchArgs)
    {
    }
    
    /**
     * @public
     * @brief This method is called back by the xoops global search feature.
     */
    function doXcoreGlobalSearch($queries, $andor, $max_hit, $start, $uid)
    {
    }
    
    /**
     * @public
     * @brief Gets a value indicating whether this module has the page controller in
     *        the control panel side.
     * @return bool
     * @note
     *    Side menu blocks may not display the admin menu if this member function returns
     *    false.
     * @attention
     *    Controller fetches the list of modules from DB before. So, 'override' may not be
     *    able to change the process.
     */
    function hasAdminIndex()
    {
        return false;
    }
    
    /**
     * @public
     * @brief [Abstract] Gets an absolute URL indicating the top page of this module for
     *        the control panel side.
     * @return string
     * @attention
     *     Controller fetches the list of modules from DB before. So, 'override' may not
     *     be able to change the process.
     */
    function getAdminIndex()
    {
        return null;
    }
    
    /**
     * @public
     * @brief Gets an array having menus for the side menu of the control panel.
     * @return Complex Array
     * @see /modules/xcore/admin/templates/blocks/xcore_admin_block_sidemenu.html
     */
    function getAdminMenu()
    {
    }
}
