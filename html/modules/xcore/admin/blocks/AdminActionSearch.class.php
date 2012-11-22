<?php

/**
 * This is test menu block for control panel of Legacy module.
 *
 * [ASSIGN]
 *  No
 * 
 * @package xcore
 */
class Xcore_AdminActionSearch extends Xcore_AbstractBlockProcedure
{
	function getName()
	{
		return "action_search";
	}

	function getTitle()
	{
		return "TEST: AdminActionSearch";
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
		$render =& $this->getRenderTarget();
		$render->setAttribute('xcore_module', 'xcore');
		$render->setTemplateName('xcore_admin_block_actionsearch.html');
		
		$root =& XCube_Root::getSingleton();
		$renderSystem =& $root->getRenderSystem($this->getRenderSystemName());
		
		$renderSystem->renderBlock($render);
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

