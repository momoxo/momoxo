<?php

class Xcore_SessionCallback extends XCube_ActionFilter
{
	function preBlockFilter()
	{
		$this->mRoot->mDelegateManager->add('XCube_Session.SetupSessionHandler', 'Xcore_SessionCallback::setupSessionHandler');
		$this->mRoot->mDelegateManager->add('XCube_Session.GetSessionCookiePath', 'Xcore_SessionCallback::getSessionCookiePath');
	}

	public static function setupSessionHandler()
	{
		$sessionHandler = xoops_gethandler('session');
		session_set_save_handler(
			array($sessionHandler, 'open'),
			array($sessionHandler, 'close'),
			array($sessionHandler, 'read'),
			array($sessionHandler, 'write'),
			array($sessionHandler, 'destroy'),
			array($sessionHandler, 'gc'));
	}
	
	public static function getSessionCookiePath(&$cookiePath) {
		$parse_array = parse_url(XOOPS_URL);
		$cookiePath = @$parse_array['path'].'/';
	}
}
