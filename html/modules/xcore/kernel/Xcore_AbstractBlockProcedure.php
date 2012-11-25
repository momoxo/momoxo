<?php

/**
 * The class for blocks which has interfaces to exchange informations with the
 * controller. The sub-class must implement these interfaces with helper
 * functions, to be called back by the controller.
 */
class Xcore_AbstractBlockProcedure
{
    /**
     * @var XCube_RenderTarget
     */
    var $mRender = null;
    
    function Xcore_AbstractBlockProcedure()
    {
    }
    
    /**
     * Preparation. If it's in exception case, returns false.
     * @return bool
     */
    function prepare()
    {
        return true;
    }
    
    /**
     * @var XCube_RenderTarget
     */
    function &getRenderTarget()
    {
        if (!is_object($this->mRender)) {
            $this->_createRenderTarget();
        }
        
        return $this->mRender;
    }

    /**
     * Gets a name of the dependence render-system.
     * @return string
     */
    function getRenderSystemName()
    {
        $root =& XCube_Root::getSingleton();
        return $root->mContext->mBaseRenderSystemName;
    }
    
    /**
     * Creates a instance of the render buffer, and set it to the property.
     * This is a helper function for sub-classes.
     * @access protected
     */
    function &_createRenderTarget()
    {
        $this->mRender = new XCube_RenderTarget();
        $this->mRender->setType(XCUBE_RENDER_TARGET_TYPE_BLOCK);
        
        return $this->mRender;
    }

    /**
     * Gets a number as ID.
     * @return int
     */
    function getId()
    {
    }

    /**
     * Gets a name of this block.
     * @return string
     */ 
    function getName()
    {
    }
    
    /**
     * Gets a value indicating whether the block can be cached.
     * @return bool
     */ 
    function isEnableCache()
    {
    }
    
    /**
     * Return cache time
     * @return int
     */
    function getCacheTime()
    {
    }

    /**
     * Gets a title of this block.
     * @return string
     */
    function getTitle()
    {
        return $this->_mBlock->get('title');
    }
    
    /**
     * Gets a column index of this block.
     * @return int
     */
    function getEntryIndex()
    {
    }
    
    /**
     * Gets a weight of this block.
     * @return int
     */
    function getWeight()
    {
    }

    /**
     * Gets a value indicating whether this block nees to display its content.
     * @return bool
     */
    function isDisplay()
    {
        return true;
    }
    
    function &createCacheInfo()
    {
        $cacheInfo = new Xcore_BlockCacheInformation();
        $cacheInfo->setBlock($this);
        return $cacheInfo;
    }
    
    function execute()
    {
    }
}
