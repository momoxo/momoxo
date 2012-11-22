<?php

class Xcore_SearchShowallbyuserAction extends Xcore_SearchShowallAction
{
	function _setupActionForm()
	{
		$this->mActionForm =new Xcore_SearchShowallbyuserForm(0);
		$this->mActionForm->prepare();
	}
	
	function _getTemplateName()
	{
		return "xcore_search_showallbyuser.html";
	}
	
	function _getSelectedMids()
	{
		$ret = array();
		$ret[] = $this->mActionForm->get('mid');
		
		return $ret;
	}
	
	function _doSearch(&$client, &$xoopsUser, &$params)
	{
		return $client->call('searchItemsOfUser', $params);
	}

	function _getMaxHit()
	{
		return XCORE_SEARCH_SHOWALL_MAXHIT;
	}
	
	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
		parent::executeViewIndex($controller, $xoopsUser, $render);
		
		$handler =& xoops_gethandler('user');
		$user =& $handler->get($this->mActionForm->get('uid'));
		
		$render->setAttribute('targetUser', $user);
		
		$prevStart = $this->mActionForm->get('start') - XCORE_SEARCH_SHOWALL_MAXHIT;
		if ($prevStart < 0) {
			$prevStart = 0;
		}

		$render->setAttribute('prevStart', $prevStart);
		$render->setAttribute('nextStart', $this->mActionForm->get('start') + XCORE_SEARCH_SHOWALL_MAXHIT);
	}
}

