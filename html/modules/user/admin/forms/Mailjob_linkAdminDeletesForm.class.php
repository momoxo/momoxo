<?php

use XCore\Form\ActionForm;
use XCore\Property\IntArrayProperty;
use XCore\Property\IntProperty;

class User_Mailjob_linkAdminDeletesForm extends ActionForm
{
	function getTokenName()
	{
		return "module.user.Mailjob_linkAdminDeletesForm.TOKEN." . $this->get('mailjob_id');
	}
	
	/**
	 * For displaying the confirm-page, don't show CSRF error.
	 * Always return null.
	 */
	function getTokenErrorMessage()
	{
		return null;
	}
	
	function prepare()
	{
		// set properties
		$this->mFormProperties['mailjob_id']=new IntProperty('mailjob_id');
		$this->mFormProperties['uid']=new IntArrayProperty('uid');
	}
}

?>
