<?php
/**
 * @file
 * @package xupdate
 * @version $Id$
**/

use XCore\Kernel\Root;
use XCore\Kernel\ActionFilter;
use XCore\Entity\Module;
use XCore\Entity\Block;

if(!defined('XOOPS_ROOT_PATH'))
{
    exit;
}

if(!defined('XUPDATE_TRUST_PATH'))
{
    define('XUPDATE_TRUST_PATH',XOOPS_TRUST_PATH . '/modules/xupdate');
}

require_once XUPDATE_TRUST_PATH . '/class/XupdateUtils.class.php';

/**
 * Xupdate_AssetPreloadBase
**/
class Xupdate_AssetPreloadBase extends ActionFilter
{
	public $mDirname = null;
	protected $blockInstance = null;
    
    /**
     * prepare
     *
     * @param   string  $dirname
     *
     * @return  void
    **/
    public static function prepare(/*** string ***/ $dirname)
    {
        static $setupCompleted = false;
        if(!$setupCompleted)
        {
            $setupCompleted = self::_setup($dirname);
        }
    }

    /**
     * _setup
     *
     * @param   void
     *
     * @return  bool
    **/
    public static function _setup($dirname)
    {
        $root = Root::getSingleton();
        $instance = new self($root->mController);
        $instance->mDirname = $dirname;
        $root->mController->addActionFilter($instance);
        return true;
    }

    /**
     * preBlockFilter
     *
     * @param   void
     *
     * @return  void
    **/
    public function preBlockFilter()
    {
        $this->mRoot->mDelegateManager->add('Module.xupdate.Global.Event.GetAssetManager','Xupdate_AssetPreloadBase::getManager');
        $this->mRoot->mDelegateManager->add('Xcore_Utils.CreateModule','Xupdate_AssetPreloadBase::getModule');
        $this->mRoot->mDelegateManager->add('Xcore_Utils.CreateBlockProcedure','Xupdate_AssetPreloadBase::getBlock');
        
        $this->mRoot->mDelegateManager->add('Xcore.Admin.Event.ModuleListSave.Success', array(&$this, '_setNeedCacheRemake'));
        $this->mRoot->mDelegateManager->add('Xcore.Admin.Event.ModuleInstall.Success', array(&$this, '_setNeedCacheRemake'));
        $this->mRoot->mDelegateManager->add('Xcore.Admin.Event.ModuleUpdate.Success', array(&$this, '_setNeedCacheRemake'));
        $this->mRoot->mDelegateManager->add('Xcore.Admin.Event.ModuleUninstall.Success', array(&$this, '_setNeedCacheRemake'));

        $this->mRoot->mDelegateManager->add('Xcore_TagClient.GetClientList','Xupdate_TagClientDelegate::getClientList', XUPDATE_TRUST_PATH.'/class/callback/TagClient.class.php');
        $this->mRoot->mDelegateManager->add('Xcore_TagClient.'.$this->mDirname.'.GetClientData','Xupdate_TagClientDelegate::getClientData', XUPDATE_TRUST_PATH.'/class/callback/TagClient.class.php');

        $this->mRoot->mDelegateManager->add('Xcoreblock.Waiting.Show',array(&$this, 'callbackWaitingShow'));

        $this->mRoot->mDelegateManager->add('Xcore_AdminControllerStrategy.SetupBlock', array(&$this, 'onXupdateSetupBlock'));
    }
	
	public function _setNeedCacheRemake() {
		$handler = Xcore_Utils::getModuleHandler('store', 'xupdate');
		$handler->setNeedCacheRemake();
	}

    /**
     * getManager
     *
     * @param   Xupdate_AssetManager  &$obj
     * @param   string  $dirname
     *
     * @return  void
    **/
    public static function getManager(/*** Xupdate_AssetManager ***/ &$obj,/*** string ***/ $dirname)
    {
        require_once XUPDATE_TRUST_PATH . '/class/AssetManager.class.php';
        $obj = Xupdate_AssetManager::getInstance($dirname);
    }

    /**
     * getModule
     *
     * @param   Xcore_AbstractModule  &$obj
     * @param   Module  $module
     *
     * @return  void
    **/
    public static function getModule(/*** Xcore_AbstractModule ***/ &$obj,/*** Module ***/ $module)
    {
        if($module->getInfo('trust_dirname') == 'xupdate')
        {
            require_once XUPDATE_TRUST_PATH . '/class/Module.class.php';
            $obj = new Xupdate_Module($module);
        }
    }

    /**
     * getBlock
     *
     * @param   Xcore_AbstractBlockProcedure  &$obj
     * @param   Block  $block
     *
     * @return  void
    **/
    public static function getBlock(/*** Xcore_AbstractBlockProcedure ***/ &$obj,/*** Block ***/ $block)
    {
        $moduleHandler =& Xupdate_Utils::getXoopsHandler('module');
        $module =& $moduleHandler->get($block->get('mid'));
        if(is_object($module) && $module->getInfo('trust_dirname') == 'xupdate')
        {
            require_once XUPDATE_TRUST_PATH . '/blocks/' . $block->get('func_file');
            $className = 'Xupdate_' . substr($block->get('show_func'), 4);
            $obj = new $className($block);
        }
    }

    function callbackWaitingShow(& $modules)
    {
    	if ($this->mRoot->mContext->mUser->isInRole('Site.Administrator')) {
    		$handler = Xcore_Utils::getModuleHandler('ModuleStore', 'xupdate');
	    	if ($count = $handler->getCountHasUpdate('module')) {
	    		$this->mRoot->mLanguageManager->loadBlockMessageCatalog('xupdate');
	    		$checkimg = '<img src="'.XOOPS_MODULE_URL.'/xupdate/admin/index.php?action=ModuleView&amp;checkonly=1" width="1" height="1" alt="" />';
	    		$blockVal = array();
	    		$blockVal['adminlink'] = XOOPS_MODULE_URL.'/xupdate/admin/index.php?action=ModuleStore&amp;filter=updated';
	    		$blockVal['pendingnum'] = $count;
	    		$blockVal['lang_linkname'] = _MB_XUPDATE_MODULEUPDATE . $checkimg;
	    		$modules[] = $blockVal;
	    	}
	    	if ($count = $handler->getCountHasUpdate('theme')) {
	    		$this->mRoot->mLanguageManager->loadBlockMessageCatalog('xupdate');
	    		$checkimg = '<img src="'.XOOPS_MODULE_URL.'/xupdate/admin/index.php?action=ModuleView&amp;checkonly=1" width="1" height="1" alt="" />';
	    		$blockVal = array();
	    		$blockVal['adminlink'] = XOOPS_MODULE_URL.'/xupdate/admin/index.php?action=ThemeStore&amp;filter=updated';
	    		$blockVal['pendingnum'] = $count;
	    		$blockVal['lang_linkname'] = _MB_XUPDATE_THEMEUPDATE . $checkimg;
	    		$modules[] = $blockVal;
	    	}
	    	if ($count = $handler->getCountHasUpdate('preload')) {
	    		$this->mRoot->mLanguageManager->loadBlockMessageCatalog('xupdate');
	    		$checkimg = '<img src="'.XOOPS_MODULE_URL.'/xupdate/admin/index.php?action=ModuleView&amp;checkonly=1" width="1" height="1" alt="" />';
	    		$blockVal = array();
	    		$blockVal['adminlink'] = XOOPS_MODULE_URL.'/xupdate/admin/index.php?action=PreloadStore&amp;filter=updated';
	    		$blockVal['pendingnum'] = $count;
	    		$blockVal['lang_linkname'] = _MB_XUPDATE_PRELOADUPDATE . $checkimg;
	    		$modules[] = $blockVal;
	    	}
    	}
    }

    public function onXupdateSetupBlock($controller)
    {
    	if ( $this->_isAdminPage() )
    	{
    		$this->blockInstance = new Xupdate_Block();
    		$this->mController->_mBlockChain[] =& $this->blockInstance;
    	}
    }
    
    protected function _isAdminPage()
    {
    	return ( strpos($_SERVER['SCRIPT_NAME'], '/admin/') !== false || strpos($_SERVER['SCRIPT_NAME'], '/admin.php') !== false );
    }

}//END CLASS

class Xupdate_Block extends Xcore_AbstractBlockProcedure
{
	function getName()
	{
		return "Xupdate_Block";
	}

	function getTitle()
	{
		return "Xupdate_Block";
	}

	function getEntryIndex()
	{
		return 0;
	}

	function isEnableCache()
	{
		return false;
	}

	function execute()
	{
		$result = '';
		
		// load data refrash image by JS
		$root = Root::getSingleton();
		$headerScript= $root->mContext->getAttribute('headerScript');
		$headerScript->addScript('var xupdateCheckImg=new Image();xupdateCheckImg.src="'.XOOPS_MODULE_URL.'/xupdate/admin/index.php?action=ModuleView&checkonly=1";');
		
		$no_notify_reg = '/action=(?:(?:Module|Theme|Preload)Install|(?:Module|Theme|Preload)Update|(?:Module|Theme|Preload)Store&filter=updated)/';
		if (!preg_match($no_notify_reg, $_SERVER['QUERY_STRING'])) {
			$handler = Xcore_Utils::getModuleHandler('ModuleStore', 'xupdate');
			$result = $handler->getNotifyHTML();
		}
		
		$render =& $this->getRenderTarget();
		$render->setResult($result);
	}

	function hasResult()
	{
		return true;
	}

	function &getResult()
	{
		$dmy = "dummy";
		return $dmy;
	}

	function getRenderSystemName()
	{
		return 'Xcore_AdminRenderSystem';
	}
}
?>
