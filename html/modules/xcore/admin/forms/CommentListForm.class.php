<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH."/modules/xcore/kernel/XCube_ActionForm.class.php";
require_once XOOPS_MODULE_PATH . "/xcore/class/Xcore_Validator.class.php";

/**
 * This class is generated by makeActionForm tool.
 * @auchor makeActionForm
 */
class Xcore_CommentListForm extends XCube_ActionForm
{
	/**
	 * If the request is GET, never return token name.
	 * By this logic, a action can have three page in one action.
	 */
	function getTokenName()
	{
		//
		//
		if (xoops_getenv('REQUEST_METHOD') == 'POST') {
			return "module.xcore.CommentSettingsForm.TOKEN";
		}
		else {
			return null;
		}
	}
	
	/**
	 * For displaying the confirm-page, don't show CSRF error.
	 * Always return null.
	 */
	function getTokenErrorMessage()
	{
		return null;
	}
	
	function prepare()
	{
		// set properties
		$this->mFormProperties['status'] =new XCube_IntArrayProperty('status');
		$this->mFormProperties['delete']= new XCube_BoolArrayProperty('delete');
		//to display error-msg at confirm-page
		$this->mFormProperties['confirm'] =new XCube_BoolProperty('confirm');

		// set fields
		$this->mFieldProperties['status'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['status']->setDependsByArray(array('required','objectExist'));
		$this->mFieldProperties['status']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_COM_STATUS);
		$this->mFieldProperties['status']->addMessage('objectExist', _AD_XCORE_ERROR_OBJECTEXIST, _AD_XCORE_LANG_COM_STATUS);
		$this->mFieldProperties['status']->addVar('handler', 'commentstatus');
		$this->mFieldProperties['status']->addVar('module', 'xcore');

	}
}

?>
