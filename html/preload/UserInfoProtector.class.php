<?php

/**
 * @brief This site preload bans access to userinfo. (A user can access self page.) 
 * 
 * If you need more expressions, you may modify a template.
 * 
 * @see http://sourceforge.net/tracker/index.php?func=detail&aid=1718508&group_id=159211&atid=943472
 */
use XCore\Kernel\Root;

class UserInfoProtector extends XCube_ActionFilter
{
	function preBlockFilter()
	{
		$root =& Root::getSingleton();
		$delegateMgr =& $root->getDelegateManager();
		
		$delegateMgr->add('Xcorepage.Userinfo.Access',
			"UserInfoProtector::rightCheck",
			XCUBE_DELEGATE_PRIORITY_2);
	}
	
	public static function rightCheck()
	{
		$root =& Root::getSingleton();
		if (!$root->mContext->mUser->mIdentity->isAuthenticated()) {
			$root->mController->executeForward(XOOPS_URL);
		}
		
		$uid = $root->mContext->mXoopsUser->get('uid');
		$requestUid = $root->mContext->mRequest->getRequest('uid');
		if ($uid != null && $uid != $requestUid) {
			$root->mController->executeForward(XOOPS_URL);
		}
	}
}
