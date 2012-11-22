<?php

class Xcore_SearchShowallAction extends Xcore_SearchResultsAction
{
	function _setupActionForm()
	{
		$this->mActionForm =new Xcore_SearchShowallForm($this->mConfig['keyword_min']);
		$this->mActionForm->prepare();
	}
	
	function _getTemplateName()
	{
		return "xcore_search_showall.html";
	}
	
	function _getSelectedMids()
	{
		$ret = array();
		$ret[] = $this->mActionForm->get('mid');
		
		return $ret;
	}
	
	function _getMaxHit()
	{
		return XCORE_SEARCH_SHOWALL_MAXHIT;
	}
	
	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
		parent::executeViewIndex($controller, $xoopsUser, $render);
		
		$prevStart = $this->mActionForm->get('start') - XCORE_SEARCH_SHOWALL_MAXHIT;
		if ($prevStart < 0) {
			$prevStart = 0;
		}
		
		$render->setAttribute('prevStart', $prevStart);
		$render->setAttribute('nextStart', $this->mActionForm->get('start') + XCORE_SEARCH_SHOWALL_MAXHIT);
	}
}

