<?php

class Xcore_NotifyCancelAction extends Xcore_Action
{
	function getDefaultView(&$contoller, &$xoopsUser)
	{
		$contoller->executeForward(XOOPS_URL . '/');
	}

	function execute(&$contoller, &$xoopsUser)
	{
		$contoller->executeForward(XOOPS_URL . '/');
	}
}

