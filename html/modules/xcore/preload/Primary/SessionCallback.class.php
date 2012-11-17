<?php
/**
 *
 * @package Xcore
 * @version $Id: SessionCallback.class.php,v 1.5 2008/09/25 15:12:38 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momonga-project/momonga>
 * @license https://github.com/momonga-project/momonga/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

class Xcore_SessionCallback extends XCube_ActionFilter
{
	function preBlockFilter()
	{
		$this->mRoot->mDelegateManager->add('XCube_Session.SetupSessionHandler', 'Xcore_SessionCallback::setupSessionHandler');
		$this->mRoot->mDelegateManager->add('XCube_Session.GetSessionCookiePath', 'Xcore_SessionCallback::getSessionCookiePath');
	}

	function setupSessionHandler()
	{
		$sessionHandler =& xoops_gethandler('session');
		session_set_save_handler(
			array(&$sessionHandler, 'open'),
			array(&$sessionHandler, 'close'),
			array(&$sessionHandler, 'read'),
			array(&$sessionHandler, 'write'),
			array(&$sessionHandler, 'destroy'),
			array(&$sessionHandler, 'gc'));
	}
	
	function getSessionCookiePath(&$cookiePath) {
		$parse_array = parse_url(XOOPS_URL);
		$cookiePath = @$parse_array['path'].'/';
	}
}