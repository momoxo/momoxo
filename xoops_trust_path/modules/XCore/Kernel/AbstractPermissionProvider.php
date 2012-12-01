<?php

namespace XCore\Kernel;

class AbstractPermissionProvider
{
	public function __construct()
	{
	}

	public function prepare()
	{
	}

	public function getRolesOfAction($actionName, $args)
	{
	}
}
