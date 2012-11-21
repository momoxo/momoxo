<?php

class Xcore_MiscSmiliesAction extends Xcore_AbstractListAction
{
	/**
	 * @var string
	 */
	var $mTargetName = null;

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('smiles', 'xcore');
		return $handler;
	}

	function &_getFilterForm()
	{
		$filter =new Xcore_SmilesFilterForm($this->_getPageNavi(), $this->_getHandler());
		return $filter;
	}

	function _getBaseUrl()
	{
		return "./misc.php?type=Smilies";
	}

	function getDefaultView(&$controller, &$xoopsUser)
	{
        $this->mTargetName = trim(xoops_getrequest('target'));
        if ($this->mTargetName == '' || !preg_match('/^[a-zA-Z]\w*$/', $this->mTargetName)) {
            return XCORE_FRAME_VIEW_ERROR;
        }
		return parent::getDefaultView($controller, $xoopsUser);
	}
	
	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
		//
		// Because this action's template uses BASE message catalog, load it.
		//
		$root =& $controller->mRoot;
		$root->mLanguageManager->loadModuleMessageCatalog('xcore');
		$root->mContext->setAttribute('xcore_pagetitle', _MD_XCORE_LANG_ALL_SMILEY_LIST);
		
		$render->setTemplateName("xcore_misc_smilies.html");
		$render->setAttribute("objects", $this->mObjects);
		$render->setAttribute("pageNavi", $this->mFilter->mNavi);
		$render->setAttribute("targetName", $this->mTargetName);
	}

	function executeViewError(&$controller, &$xoopsUser, &$render)
    {
        $render->setTemplateName("xcore_dummy.html");
    }
}

?>
