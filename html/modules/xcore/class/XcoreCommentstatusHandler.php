<?php

use XCore\Kernel\Root;
use XCore\Repository\ObjectRepository;

class XcoreCommentstatusHandler extends ObjectRepository
{
	var $_mResults = array();
	
	function XcoreCommentstatusHandler(&$db)
	{
		$root = Root::getSingleton();
		$language = $root->mContext->getXoopsConfig('language');
		$root->mLanguageManager->loadPageTypeMessageCatalog('comment');

		$this->_mResults[XOOPS_COMMENT_PENDING] =& $this->create();
		$this->_mResults[XOOPS_COMMENT_PENDING]->setVar('id', XOOPS_COMMENT_PENDING);
		$this->_mResults[XOOPS_COMMENT_PENDING]->setVar('name', _CM_PENDING);
		
		$this->_mResults[XOOPS_COMMENT_ACTIVE] =& $this->create();
		$this->_mResults[XOOPS_COMMENT_ACTIVE]->setVar('id', XOOPS_COMMENT_ACTIVE);
		$this->_mResults[XOOPS_COMMENT_ACTIVE]->setVar('name', _CM_ACTIVE);

		$this->_mResults[XOOPS_COMMENT_HIDDEN] =& $this->create();
		$this->_mResults[XOOPS_COMMENT_HIDDEN]->setVar('id', XOOPS_COMMENT_HIDDEN);
		$this->_mResults[XOOPS_COMMENT_HIDDEN]->setVar('name', _CM_HIDDEN);
	}
	
	function &create()
	{
		$ret =new XcoreCommentstatusObject();
		return $ret;
	}
	
	function &get($id)
	{
		if (isset($this->_mResults[$id])) {
			return $this->_mResults[$id];
		}
		
		$ret = null;
		return $ret;
	}
	
	function &getObjects($criteria = null, $id_as_key = false)
	{
		if ($id_as_key) {
			return $this->_mResults;
		}
		else {
			$ret = array();
		
			foreach (array_keys($this->_mResults) as $key) {
				$ret[] =& $this->_mResults[$key];
			}
			
			return $ret;
		}
	}
	
	function insert(&$obj)
	{
		return false;
	}

	function delete(&$obj)
	{
		return false;
	}
}
