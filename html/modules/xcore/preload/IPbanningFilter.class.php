<?php

/***
 * This burns the access from the specific IP address, which is specified at
 * the preference.
 */
class Xcore_IPbanningFilter extends XCube_ActionFilter
{
	function preBlockFilter()
	{
		if ($this->mRoot->mContext->getXoopsConfig('enable_badips')) {
			if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR']) {
				foreach ($this->mRoot->mContext->mXoopsConfig['bad_ips'] as $bi) {
					$bi = str_replace('.', '\.', $bi);
					if (!empty($bi) && preg_match("/".$bi."/", $_SERVER['REMOTE_ADDR'])) {
						throw new RuntimeException();
					}
				}
			}
		}
	}
}
