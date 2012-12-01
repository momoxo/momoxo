<?php

namespace XCore\Kernel;

class AbstractPermissionProvider
{
	function __construct()
	{
	}

	function prepare()
	{
	}

	function getRolesOfAction($actionName, $args)
	{
	}
}
