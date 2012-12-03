<?php

use XCore\Form\ActionForm;

class User_UserConfirmForm extends ActionForm
{
	function getTokenName()
	{
		return "module.user.UserConfirmForm.TOKEN";
	}

	function prepare()
	{
	}
}
