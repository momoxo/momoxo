<?php

use XCore\Kernel\Ref;
use XCore\Kernel\Delegate;

class Xcore_BlockCacheInformation extends Xcore_AbstractCacheInformation
{
    /**
     * [READ ONLY] Xoops Block Object.
     * 
     * @access protected
     * @var XoopsBlock
     */
     var $mBlock = null;
     
     /**
      * @var Delegate
      */
     var $mGetCacheFilePath = null;
     
     function Xcore_BlockCacheInformation()
     {
         parent::Xcore_AbstractCacheInformation();
         $this->mGetCacheFilePath = new Delegate();
         $this->mGetCacheFilePath->register('Xcore_BlockCachInformation.getCacheFilePath');
     }
     
     /**
      * Sets a block object.
      * 
      * @param Xcore_AbstractBlockProcedure $blockProcedure
      */
     function setBlock(&$blockProcedure)
     {
         $this->mBlock =& $blockProcedure->_mBlock;
     }
     
     function reset()
     {
         parent::reset();
         $this->mBlock = null;
     }

    /**
     * Gets a file path of a cache file for module contents.
     * @param Xcore_BlockCacheInformation $cacheInfo
     * @return string
     */
    function getCacheFilePath()
    {
        $filepath = null;
        $this->mGetCacheFilePath->call(new Ref($filepath), $this);
        
        if (!$filepath) {
            $id = md5(XOOPS_SALT . '(' . implode('_', $this->mIdentityArr) . ')' . implode('_', $this->mGroupArr));
            $filepath = $this->getCacheFileBase($this->mBlock->get('bid'), $id);
        }
        return $filepath;
    }

    static function getCacheFileBase($bid, $context) {
		return XOOPS_CACHE_PATH . '/' . urlencode(XOOPS_URL) . '_bid'. $bid . '_' . $context . '.cache.html';
	}
}
