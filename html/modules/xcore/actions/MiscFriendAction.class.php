<?php

class Xcore_MiscFriendAction extends Xcore_Action
{
	var $mActionForm = null;
	var $mMailer = null;
	
	function hasPermission(&$controller, &$xoopsUser)
	{
		return is_object($xoopsUser);
	}

	function prepare(&$controller, &$xoopsUser)
	{
		$this->mActionForm =new Xcore_MiscFriendForm();
		$this->mActionForm->prepare();
	}

	function getDefaultView(&$controller, &$xoopsUser)
	{
		$this->mActionForm->load($xoopsUser);
		return XCORE_FRAME_VIEW_INPUT;
	}
	
	function execute(&$controller, &$xoopsUser)
	{
		$this->mActionForm->fetch();
		$this->mActionForm->validate();
		
		if ($this->mActionForm->hasError()) {
			return XCORE_FRAME_VIEW_INPUT;
		}
		
		$root =& XCube_Root::getSingleton();
		
		$this->mMailer =& getMailer();
		$this->mMailer->setTemplate("tellfriend.tpl");
		$this->mMailer->assign("SITENAME", $root->mContext->getXoopsConfig('sitename'));
		$this->mMailer->assign("ADMINMAIL", $root->mContext->getXoopsConfig('adminmail'));
		$this->mMailer->assign("SITEURL", XOOPS_URL . '/');
		
		$this->mActionForm->update($this->mMailer);
		
		$root->mLanguageManager->loadPageTypeMessageCatalog("misc");
		
		$this->mMailer->setSubject(sprintf(_MSC_INTSITE, $root->mContext->getXoopsConfig('sitename')));
		
		return $this->mMailer->send() ? XCORE_FRAME_VIEW_SUCCESS : XCORE_FRAME_VIEW_ERROR;
	}
	
	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName("xcore_misc_friend.html");
		$render->setAttribute('actionForm', $this->mActionForm);
	}

	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName("xcore_misc_friend_success.html");
	}

	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName("xcore_misc_friend_error.html");
		$render->setAttribute('xoopsMailer', $this->mMailer);
	}
}

?>
