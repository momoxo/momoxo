<?php

/***
 * @internal
 */
class Xcore_ImageListAction extends Xcore_AbstractListAction
{
	var $mImgcatId = null;
	
	function prepare(&$controller, &$xoopsUser)
	{
		$controller->setDialogMode(true);
		
		$root =& $controller->mRoot;
		$root->mLanguageManager->loadModuleMessageCatalog('xcore');
	}
	
	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('image', 'xcore');
		return $handler;
	}

	function &_getFilterForm()
	{
		$filter =new Xcore_ImageFilterForm($this->_getPageNavi(), $this->_getHandler());
		return $filter;
	}

	function _getBaseUrl()
	{
		return XOOPS_URL . "/imagemanager.php?op=list";
	}
	
	function getDefaultView(&$controller, &$xoopsUser)
	{
		$result = parent::getDefaultView($controller, $xoopsUser);
		if ($result == XCORE_FRAME_VIEW_INDEX) {
			$this->mImgcatId = xoops_getrequest('imgcat_id');
			$handler =& xoops_getmodulehandler('imagecategory', 'xcore');
			$this->mCategory =& $handler->get($this->mImgcatId );
		}
		
		return $result;
	}

	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName("xcore_image_list.html");
		
		foreach (array_keys($this->mObjects) as $key) {
			$this->mObjects[$key]->loadImagecategory();
		}
		
		$render->setAttribute("objects", $this->mObjects);
		$render->setAttribute("pageNavi", $this->mFilter->mNavi);
		
		$render->setAttribute('imgcatId', $this->mImgcatId);
		
		$handler =& xoops_getmodulehandler('imagecategory', 'xcore');
		
		if (is_object($xoopsUser)) {
			$groups = $xoopsUser->getGroups();
		}
		else {
			$groups = array(XOOPS_GROUP_ANONYMOUS);
		}
		$categoryArr =& $handler->getObjectsWithReadPerm($groups, 1);
		
		$render->setAttribute('categoryArr', $categoryArr);
		
		//
		// If current category object exists, check the permission of uploading.
		//
		$hasUploadPerm = null;
		if ($this->mCategory != null) {
			$hasUploadPerm = $this->mCategory->hasUploadPerm($groups);
		}
		$render->setAttribute('hasUploadPerm', $hasUploadPerm);
		$render->setAttribute("category", $this->mCategory);
        $render->setAttribute('target', htmlspecialchars(xoops_getrequest('target'), ENT_QUOTES));
	}

	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward(XOOPS_URL . "/imagemanager.php?op=list");
	}
}

