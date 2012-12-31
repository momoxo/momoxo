<?php

use XCore\Entity\SimpleObject;
use XCore\Utils\TextSanitizer;

class XcoreCommentObject extends SimpleObject
{
	var $mUser = null;
	var $mModule = null;
	var $mStatus = null;
	
	function XcoreCommentObject()
	{
		static $initVars;
		if (isset($initVars)) {
			$this->mVars = $initVars;
			return;
		}
		$this->initVar('com_id', XOBJ_DTYPE_INT, '', true);
		$this->initVar('com_pid', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('com_rootid', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('com_modid', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('com_itemid', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('com_icon', XOBJ_DTYPE_STRING, '', true, 25);
		$this->initVar('com_created', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('com_modified', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('com_uid', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('com_ip', XOBJ_DTYPE_STRING, '', true, 15);
		$this->initVar('com_title', XOBJ_DTYPE_STRING, '', true, 255);
		$this->initVar('com_text', XOBJ_DTYPE_TEXT, '', true);
		$this->initVar('com_sig', XOBJ_DTYPE_BOOL, '0', true);
		$this->initVar('com_status', XOBJ_DTYPE_INT, '1', true);
		$this->initVar('com_exparams', XOBJ_DTYPE_STRING, '', true, 255);
		$this->initVar('dohtml', XOBJ_DTYPE_BOOL, '0', true);
		$this->initVar('dosmiley', XOBJ_DTYPE_BOOL, '1', true);
		$this->initVar('doxcode', XOBJ_DTYPE_BOOL, '1', true);
		$this->initVar('doimage', XOBJ_DTYPE_BOOL, '1', true);
		$this->initVar('dobr', XOBJ_DTYPE_BOOL, '1', true);
		$initVars=$this->mVars;
	}
	
	/**
	 * Load a user object who wrote this comment to $mUser. 
	 */
	function loadUser()
	{
		$handler =& xoops_gethandler('member');
		$this->mUser =& $handler->getUser($this->get('com_uid'));
	}
	
	/**
	 * Load a module object to $mModule. 
	 */
	function loadModule()
	{
		$handler =& xoops_gethandler('module');
		$this->mModule =& $handler->get($this->get('com_modid'));
	}
	
	function loadStatus()
	{
		$handler =& xoops_getmodulehandler('commentstatus', 'xcore');
		$this->mStatus =& $handler->get($this->get('com_status'));
	}
	
	function getVar($key)
	{
		if ($key == 'com_text') {
			$ts =& TextSanitizer::getInstance();
			return $ts->displayTarea($this->get($key), $this->get('dohtml'), $this->get('dosmiley'), $this->get('doxcode'), $this->get('doimage'), $this->get('dobr'));
		}
		else {
			return parent::getVar($key);
		}
	}
}
