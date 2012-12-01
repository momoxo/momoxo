<?php

use XCore\Kernel\Root;

class Xcore_ImagecategoryListAction extends Xcore_AbstractListAction
{
	var $mImagecategoryObjects = array();
	var $mActionForm = null;
	var $mpageArr = array(5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 60, 70, 80, 90, 100, 0);

	function prepare(&$controller, &$xoopsUser)
	{
		$this->mActionForm =new Xcore_ImagecategoryListForm();
		$this->mActionForm->prepare();
	}

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('imagecategory');
		return $handler;
	}

	function &_getPageNavi()
	{
		$navi =new XCube_PageNavigator($this->_getBaseUrl(), XCUBE_PAGENAVI_START | XCUBE_PAGENAVI_PERPAGE);

		$root =& Root::getSingleton();
		$perpage = $root->mContext->mRequest->getRequest($navi->mPrefix.'perpage');
		if (isset($perpage) && intval($perpage) == 0) { 	
		$navi->setPerpage(0);
		}
		return $navi;
	}

	function &_getFilterForm()
	{
		$filter =new Xcore_ImagecategoryFilterForm($this->_getPageNavi(), $this->_getHandler());
		return $filter;
	}

	function _getBaseUrl()
	{
		return "./index.php?action=ImagecategoryList";
	}

	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName("imagecategory_list.html");
		$render->setAttribute("objects", $this->mObjects);
		$render->setAttribute("pageNavi", $this->mFilter->mNavi);
		$render->setAttribute('actionForm', $this->mActionForm);
		$render->setAttribute('pageArr', $this->mpageArr);
		$render->setAttribute('filterForm', $this->mFilter);

		$imgcat_handler =& $this->_getHandler();
		$imgcat_total = $imgcat_handler->getCount();
		$file_imgcat_total = $imgcat_handler->getCount(new Criteria('imgcat_storetype', 'file'));
		$render->setAttribute('ImgcatTotal', $imgcat_total);
		$render->setAttribute('fileImgcatTotal', $file_imgcat_total);
		$render->setAttribute('dbImgcatTotal', $imgcat_total - $file_imgcat_total);
		//total of image(s)
		$image_handler =& xoops_getmodulehandler('image');
		$image_total = $image_handler->getCount();
		$display_image_total = $image_handler->getCount(new Criteria('image_display', 1));
		$render->setAttribute('ImageTotal', $image_total);
		$render->setAttribute('displayImageTotal', $display_image_total);
		$render->setAttribute('notdisplayImageTotal', $image_total - $display_image_total);
	}

	function execute(&$controller, &$xoopsUser)
	{
		$form_cancel = $controller->mRoot->mContext->mRequest->getRequest('_form_control_cancel');
		if ($form_cancel != null) {
			return XCORE_FRAME_VIEW_CANCEL;
		}

		$this->mActionForm->fetch();
		$this->mActionForm->validate();

		if ($this->mActionForm->hasError()) {
			return $this->_processConfirm($controller, $xoopsUser);
		}
		else {
			return $this->_processSave($controller, $xoopsUser);
		}
	}
	
	function _processConfirm(&$controller,&$xoopsUser)
	{
        		$nameArr = $this->mActionForm->get('name');
		$imagecategoryHandler =& xoops_getmodulehandler('imagecategory');
		//
		// Do mapping.
		//
		foreach (array_keys($nameArr) as $icid) {
			$imagecategory =& $imagecategoryHandler->get($icid);
			if (is_object($imagecategory)) {
			$this->mImagecategoryObjects[$icid] =& $imagecategory;
			}
			unset($imagecategory);
		}
	

		return XCORE_FRAME_VIEW_INPUT;
	}

    function _processSave(&$controller, &$xoopsUser)
    {
        		$nameArr = $this->mActionForm->get('name');
        		$imagecategoryHandler =& xoops_getmodulehandler('imagecategory');

        		foreach(array_keys($nameArr) as $icid) {
			$imagecategory =& $imagecategoryHandler->get($icid);
			if (is_object($imagecategory)) {
            		$olddata['name'] = $imagecategory->get('imgcat_name');
            		$olddata['weight'] = $imagecategory->get('imgcat_weight');
            		$olddata['maxsize'] = $imagecategory->get('imgcat_maxsize');
            		$olddata['maxwidth'] = $imagecategory->get('imgcat_maxwidth');
            		$olddata['maxheight'] = $imagecategory->get('imgcat_maxheight');
            		$olddata['display'] = $imagecategory->get('imgcat_display');
            		$newdata['name'] = $this->mActionForm->get('name', $icid);
            		$newdata['weight'] = $this->mActionForm->get('weight', $icid);
            		$newdata['maxsize'] = $this->mActionForm->get('maxsize', $icid);
            		$newdata['maxwidth'] = $this->mActionForm->get('maxwidth', $icid);
            		$newdata['maxheight'] = $this->mActionForm->get('maxheight', $icid);
            		$newdata['display'] = $this->mActionForm->get('display', $icid);
            		if (count(array_diff_assoc($olddata, $newdata)) > 0 ) {
                		$imagecategory->set('imgcat_name', $this->mActionForm->get('name', $icid));
                		$imagecategory->set('imgcat_weight', $this->mActionForm->get('weight', $icid));
                		$imagecategory->set('imgcat_maxsize', $this->mActionForm->get('maxsize', $icid));
                		$imagecategory->set('imgcat_maxwidth', $this->mActionForm->get('maxwidth', $icid));
                		$imagecategory->set('imgcat_maxheight', $this->mActionForm->get('maxheight', $icid));
                		$imagecategory->set('imgcat_display', $this->mActionForm->get('display', $icid));
                		if (!$imagecategoryHandler->insert($imagecategory)) {
				return XCORE_FRAME_VIEW_ERROR;
                		}
            		}//count if
			}//object if
        		}//foreach

        		foreach(array_keys($nameArr) as $icid) {
		if($this->mActionForm->get('delete', $icid) == 1) {
			$imagecategory =& $imagecategoryHandler->get($icid);
			if (is_object($imagecategory)) {
				if( !$imagecategoryHandler->delete($imagecategory) ) {
				return XCORE_FRAME_VIEW_ERROR;
				}
			}
		}
		}
		return XCORE_FRAME_VIEW_SUCCESS;

    }

	/**
	 * To support a template writer, this send the list of mid that actionForm kept.
	 */
	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName("imagecategory_list_confirm.html");
		$render->setAttribute('imagecategoryObjects', $this->mImagecategoryObjects);
		$render->setAttribute('actionForm', $this->mActionForm);
		//
		// To support a template writer, this send the list of mid that
		// actionForm kept.
		//
		$t_arr = $this->mActionForm->get('name');
		$render->setAttribute('icids', array_keys($t_arr));
	}


	function executeViewSuccess(&$controller,&$xoopsUser,&$renderer)
	{
		$controller->executeForward('./index.php?action=ImagecategoryList');
	}

	function executeViewError(&$controller, &$xoopsUser, &$renderer)
	{
		$controller->executeRedirect('./index.php?action=ImagecategoryList', 1, _MD_XCORE_ERROR_DBUPDATE_FAILED);
	}

	function executeViewCancel(&$controller,&$xoopsUser,&$renderer)
	{
		$controller->executeForward('./index.php?action=ImagecategoryList');
	}

}

