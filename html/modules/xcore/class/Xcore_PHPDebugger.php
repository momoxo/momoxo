<?php

class Xcore_PHPDebugger extends Xcore_AbstractDebugger
{
	function prepare()
	{
		error_reporting(E_ALL);
		$GLOBALS['xoopsErrorHandler'] =& XoopsErrorHandler::getInstance();
		$GLOBALS['xoopsErrorHandler']->activate(true);
	}
}
