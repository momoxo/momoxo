<?php

class Xcore_ImageEditAction extends Xcore_ImageCreateAction
{
	function _getId()
	{
		return isset($_REQUEST['image_id']) ? xoops_getrequest('image_id') : 0;
	}

	function _setupActionForm()
	{
		$this->mActionForm =new Xcore_ImageAdminEditForm();
		$this->mActionForm->prepare();
	}
	
	function isEnableCreate()
	{
		return false;
	}
	
	function _enableCatchImgcat()
	{
		return false;
	}
	
	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		$this->mObject->loadImagecategory();

		$render->setTemplateName("image_edit.html");
		$render->setAttribute('actionForm', $this->mActionForm);
		$render->setAttribute('object', $this->mObject);
		
		$handler =& xoops_getmodulehandler('imagecategory', 'xcore');
		$t_category = $handler->get($this->mObject->get('imgcat_id'));
		
		$categoryArr =& $handler->getObjects(new Criteria('imgcat_storetype', $t_category->get('imgcat_storetype')));
		$render->setAttribute('categoryArr', $categoryArr);
	}
	
	function executeViewCancel(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward('./index.php?action=ImageList&imgcat_id=' . $this->mObject->get('imgcat_id'));
	}
}

?>
