<?php

/**
 * This class extends the base class to exchange of information with the
 * controller. And, it has a XoopsBlock instance, and some public methods for
 * the public side and the control panel side.
 */
class Xcore_BlockProcedure extends Xcore_AbstractBlockProcedure
{
    /**
     * @var XoopsBlock
     */
    var $_mBlock = null;
    
    /**
     * @var XCube_RenderTarget
     */
    var $mRender = null;
    
    function Xcore_BlockProcedure(&$block)
    {
        $this->_mBlock =& $block;
    }
    
    function prepare()
    {
        return true;
    }
    
    function getId()
    {
        return $this->_mBlock->get('bid');
    }
    
    function getName()
    {
        return $this->_mBlock->get('name');
    }
    
    function isEnableCache()
    {
        return $this->_mBlock->get('bcachetime') > 0;
    }
    
    function getCacheTime()
    {
        return $this->_mBlock->get('bcachetime');
    }

    function getTitle()
    {
        return $this->_mBlock->get('title');
    }
    
    function getEntryIndex()
    {
        return $this->_mBlock->getVar('side');
    }
    
    function getWeight()
    {
        return $this->_mBlock->get('weight');
    }
    
    /**
     * @public
     * @breaf [Secret Agreement] Gets a value indicating whether the option form of this block needs the row to display the form.
     * @remark Only block management actions should use this method, and this method should not be overridden usually.
     */
    function _hasVisibleOptionForm()
    {
        return true;
    }
    
    /**
     * Gets rendered HTML buffer for the option form of the control panel.
     * @return string
     */
    function getOptionForm()
    {
        return null;
    }
}
