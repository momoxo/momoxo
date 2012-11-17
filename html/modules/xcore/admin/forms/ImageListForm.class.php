<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH."/core/XCube_ActionForm.class.php";

/**
 * This class is generated by makeActionForm tool.
 * @auchor makeActionForm
 */
class Xcore_ImageListForm extends XCube_ActionForm
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
			return "module.xcore.ImageSettingsForm.TOKEN";
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
		$this->mFormProperties['nicename']=new XCube_StringArrayProperty('nicename');
		$this->mFormProperties['weight']=new XCube_IntArrayProperty('weight');
		$this->mFormProperties['display']=new XCube_BoolArrayProperty('display');
		$this->mFormProperties['delete']=new XCube_BoolArrayProperty('delete');
		//to display error-msg at confirm-page
		$this->mFormProperties['confirm'] =new XCube_BoolProperty('confirm');
		// set fields
		$this->mFieldProperties['nicename'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['nicename']->setDependsByArray(array('required'));
		$this->mFieldProperties['nicename']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_XCORE_LANG_IMAGE_NICENAME);

		$this->mFieldProperties['weight'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['weight']->setDependsByArray(array('required'));
		$this->mFieldProperties['weight']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_IMAGE_WEIGHT);

	}
}

?>
