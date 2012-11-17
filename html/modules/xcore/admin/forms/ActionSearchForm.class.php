<?php
/**
 *
 * @package Xcore
 * @version $Id: ActionSearchForm.class.php,v 1.4 2008/09/25 15:11:16 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momonga-project/momonga>
 * @license https://github.com/momonga-project/momonga/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH."/modules/xcore/kernel/XCube_ActionForm.class.php";

class Xcore_ActionSearchForm extends XCube_ActionForm
{
	var $mState = null;
	
	function prepare()
	{
		$this->mFormProperties['keywords']=new XCube_StringProperty('keywords');

		// set fields
		$this->mFieldProperties['keywords']=new XCube_FieldProperty($this);
		$this->mFieldProperties['keywords']->setDependsByArray(array('required'));
		$this->mFieldProperties['keywords']->addMessage("required",_AD_XCORE_ERROR_SEARCH_REQUIRED);
	}

	function fetch()
	{
		parent::fetch();
		$this->set('keywords', trim($this->get('keywords')));
	}
}	
