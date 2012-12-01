<?php
/**
 * @file
 * @package xupdate
**/

use XCore\Kernel\Root;

if(!defined('XOOPS_ROOT_PATH'))
{
    exit();
}

/**
 * Xupdate_NotifyBlock
**/
class Xupdate_NotifyBlock extends Xcore_BlockProcedure
{
    /**
     * @var Xupdate_ModuleHandler
     * 
     * @private
    **/
    protected $_mHandler = null;
    
    /**
     * @protected Xcore_AbstractCategoryObject
     * 
     * @private
    **/
    protected $_mOject = null;
    
    /**
     * @protected int
     * 
     * @private
    **/
    protected $_mCount = array();
    
    /**
     * @protected string[]
     * 
     * @private
    **/
    protected $_mOptions = array();
    
    /**
     * prepare
     * 
     * @param   void
     * 
     * @return  bool
     * 
     * @public
    **/
    public function prepare()
    {
        return parent::prepare() && $this->_setupObject($this->_mBlock->get('dirname'));
    }
    
    /**
     * _setupObject
     * 
     * @param   void
     * 
     * @return  bool
     * 
     * @private
    **/
    protected function _setupObject($dirname)
    {
    	$root = Root::getSingleton();
    	$roleManager = new Xcore_RoleManager();
    	$roleManager->loadRolesByDirname($dirname);
    	if ($root->mContext->mUser->isInRole('Module.'.$dirname.'.Admin')) {
    		$this->_mHandler = Xcore_Utils::getModuleHandler('ModuleStore', $dirname);
			return true;
    	} else {
    		return false;
    	}
    }

    /**
     * execute
     * 
     * @param   void
     * 
     * @return  void
     * 
     * @public
    **/
    public function execute()
    {
        $result = '';
        
        // load data refrash image by JS
        $root = Root::getSingleton();
        $headerScript= $root->mContext->getAttribute('headerScript');
        $headerScript->addScript('var xupdateCheckImg=new Image();xupdateCheckImg.src="'.XOOPS_MODULE_URL.'/xupdate/admin/index.php?action=ModuleView&checkonly=1";');
        
       	$result = $this->_mHandler->getNotifyHTML();
        
        $render =& $this->getRenderTarget();
        $render->setResult($result);
        
    }
    
    function getTitle()
    {
    	return '';
    }
}

?>
