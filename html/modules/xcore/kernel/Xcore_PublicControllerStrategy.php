<?php

use XCore\Kernel\Root;

class Xcore_PublicControllerStrategy extends Xcore_AbstractControllerStrategy
{
	var $mStatusFlag = XCORE_CONTROLLER_STATE_PUBLIC;
	
	function __construct(&$controller)
	{
		parent::__construct($controller);
		
		$controller->mRoot->mContext->mBaseRenderSystemName = "Xcore_RenderSystem";
		
		if (!defined("XCORE_DEPENDENCE_RENDERER")) {
			define("XCORE_DEPENDENCE_RENDERER", "Xcore_RenderSystem");
		}
	}

	function setupBlock()
	{
		$showFlag =0;
		$mid=0;

		if($this->mController->mRoot->mContext->mModule != null) {
			$showFlag = (preg_match("/index\.php$/i", xoops_getenv('PHP_SELF')) && $this->mController->mRoot->mContext->mKarimojiConfig['startpage'] == $this->mController->mRoot->mContext->mKarimojiModule->get('dirname'));
			$mid = $this->mController->mRoot->mContext->mKarimojiModule->get('mid');
		}
		else {
			//
			// If you does not have module_contoller, this request is to toppage or other pages of toppage.
			//

			// $mid = preg_match("/index\.php$/i", xoops_getenv('PHP_SELF')) ? -1 : 0;
			$pathArray = parse_url(!empty($_SERVER['PATH_INFO']) ? substr($_SERVER['PHP_SELF'],0,- strlen($_SERVER['PATH_INFO'])) : $_SERVER['PHP_SELF']);
			$mid = preg_match("#(/index\.php|/)$#i", @$pathArray['path']) ? -1 : 0;
		}

        $blockHandler =& xoops_gethandler('block');
		$showCenterFlag = (SHOW_CENTERBLOCK_LEFT | SHOW_CENTERBLOCK_CENTER | SHOW_CENTERBLOCK_RIGHT);
		$showRightFlag = SHOW_SIDEBLOCK_RIGHT;
		$showFlag = SHOW_SIDEBLOCK_LEFT | $showRightFlag | $showCenterFlag;
		$groups = is_object($this->mController->mRoot->mContext->mKarimojiUser) ? $this->mController->mRoot->mContext->mKarimojiUser->getGroups() : XOOPS_GROUP_ANONYMOUS;

		$blockObjects =& $blockHandler->getBlocks($groups, $mid, $showFlag);
		foreach($blockObjects as $blockObject) {
			$block =& Xcore_Utils::createBlockProcedure($blockObject);

			if ($block->prepare() !== false) {
				$this->mController->_mBlockChain[] =& $block;
			}
			unset($block);
			unset($blockObject);
		}
	}

	function &getMainThemeObject()
	{
		// [TODO]
		// Because get() of the virtual handler is heavy, we have to consider
		// the new solution about this process.
		//
		$handler =& xoops_getmodulehandler('theme', 'xcore');
		$theme =& $handler->get($this->mController->mRoot->mContext->getThemeName());
		if (is_object($theme)) {
			return $theme;
		}

		//-----------
		// Fail safe
		//-----------
		
		$root = Root::getSingleton();
		foreach ($root->mContext->mKarimojiConfig['theme_set_allowed'] as $theme) {
			$theme =& $handler->get($theme);
			if (is_object($theme)) {
				$root->mContext->setThemeName($theme->get('dirname'));
				return $theme;
			}
		}
		
		$objs =& $handler->getObjects();
		if (count($objs) > 0) {
			return $objs[0];
		}

		$theme = null;
		return $theme;
	}
	
	function isEnableCacheFeature()
	{
		return true;
	}
	
	function enableAccess()
	{
		if ($this->mController->mRoot->mContext->mModule != null) {
			$dirname = $this->mController->mRoot->mContext->mKarimojiModule->get('dirname');
			
			return $this->mController->mRoot->mContext->mUser->isInRole("Module.${dirname}.Visitor");
		}
		
		return true;
	}
	
	function setupModuleLanguage()
	{
		$root = Root::getSingleton();
		$root->mLanguageManager->loadModuleMessageCatalog($root->mContext->mKarimojiModule->get('dirname'));
	}
}
