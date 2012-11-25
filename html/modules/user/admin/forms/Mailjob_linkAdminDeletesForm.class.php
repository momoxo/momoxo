<?php

class User_Mailjob_linkAdminDeletesForm extends XCube_ActionForm 
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
		$this->mFormProperties['mailjob_id']=new XCube_IntProperty('mailjob_id');
		$this->mFormProperties['uid']=new XCube_IntArrayProperty('uid');
	}
}

?>
