<?php

use XCore\Form\ActionForm;

if (!defined('XOOPS_ROOT_PATH')) exit();

class User_UserDeleteForm extends ActionForm
{
	function getTokenName()
	{
		return "module.user.UserDeleteForm.TOKEN";
	}

	function prepare()
	{
	}
}
