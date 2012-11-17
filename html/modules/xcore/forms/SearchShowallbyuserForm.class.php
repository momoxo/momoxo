<?php
/**
 *
 * @package Xcore
 * @version $Id: SearchShowallbyuserForm.class.php,v 1.4 2008/09/25 15:12:39 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momonga-project/momonga>
 * @license https://github.com/momonga-project/momonga/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/modules/xcore/kernel/XCube_ActionForm.class.php";
require_once XOOPS_MODULE_PATH . "/xcore/class/Xcore_Validator.class.php";

require_once XOOPS_MODULE_PATH . "/xcore/forms/SearchShowallForm.class.php";

class Xcore_SearchShowallbyuserForm extends Xcore_SearchShowallForm
{
	function prepare()
	{
		parent::prepare();
		
		//
		// Set form properties
		//
		$this->mFormProperties['uid'] =new XCube_IntProperty('uid');
		$this->mFormProperties['mid'] =new XCube_IntProperty('mid');
		$this->mFormProperties['start'] =new XCube_IntProperty('start');
		
		//
		// Set field properties
		//
		$this->mFieldProperties['uid'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['uid']->setDependsByArray(array('required'));
		$this->mFieldProperties['uid']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_XCORE_LANG_UID);
		
		$this->mFieldProperties['mid'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['mid']->setDependsByArray(array('required'));
		$this->mFieldProperties['mid']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_XCORE_LANG_MID);
	}
	
	function update(&$params)
	{
		$params['uid'] = $this->get('uid');
		$params['start'] = $this->get('start');
		
		if (defined("XCORE_SEARCH_SHOWALL_MAXHIT")) {
			$params['maxhit'] = XCORE_SEARCH_SHOWALL_MAXHIT;
		}
		else {
			$params['maxhit'] = 20;
		}
	}
}

?>
