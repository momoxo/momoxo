<?php

class protectorLE_Filter extends XCube_ActionFilter
{
	function getCheckRequestKeys()
	{
		$checkNames=array('GLOBALS', '_SESSION', 'HTTP_SESSION_VARS', '_GET', 'HTTP_GET_VARS',
							'_POST', 'HTTP_POST_VARS', '_COOKIE', 'HTTP_COOKIE_VARS', '_REQUEST',
							'_SERVER', 'HTTP_SERVER_VARS', '_ENV', 'HTTP_ENV_VARS', '_FILES',
							'HTTP_POST_FILES', 'xoopsDB', 'xoopsUser', 'xoopsUserId', 'xoopsUserGroups',
							'xoopsUserIsAdmin', 'xoopsConfig', 'xoopsOption', 'xoopsModule', 'xoopsModuleConfig');
							
		return $checkNames;
	}

	function preFilter()
	{
		foreach($this->getCheckRequestKeys() as $name) {
			if (isset($_REQUEST[$name])) {
				throw new RuntimeException();
			}
		}
	}
}
