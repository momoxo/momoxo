<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

class User_UserDeleteForm extends XCube_ActionForm
{
	function getTokenName()
	{
		return "module.user.UserDeleteForm.TOKEN";
	}

	function prepare()
	{
	}
}
