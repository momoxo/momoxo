<?php

class Xcore_DebuggerManager
{
	/***
	Create XoopsDebugger instance.
	You must not communicate with this method directly.
	*/
	function createInstance(&$instance, $debug_mode)
	{
		if (is_object($instance)) {
			return;
		}
		
		switch($debug_mode) {
			case XOOPS_DEBUG_PHP:
				$instance = new Xcore_PHPDebugger();
				break;

			case XOOPS_DEBUG_MYSQL:
				$instance = new Xcore_MysqlDebugger();
				break;

			case XOOPS_DEBUG_SMARTY:
				$instance = new Xcore_SmartyDebugger();
				break;
			
			case XOOPS_DEBUG_OFF:
			default:
				$instance = new Xcore_NonDebugger();
				break;
		}
	}
}
