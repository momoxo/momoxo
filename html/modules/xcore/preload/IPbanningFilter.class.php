<?php

/***
 * This burns the access from the specific IP address, which is specified at
 * the preference.
 */
use XCore\Kernel\ActionFilter;

class Xcore_IPbanningFilter extends ActionFilter
{
	function preBlockFilter()
	{
		if ($this->mRoot->mContext->getXoopsConfig('enable_badips')) {
			if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR']) {
				foreach ($this->mRoot->mContext->mKarimojiConfig['bad_ips'] as $bi) {
					$bi = str_replace('.', '\.', $bi);
					if (!empty($bi) && preg_match("/".$bi."/", $_SERVER['REMOTE_ADDR'])) {
						throw new RuntimeException();
					}
				}
			}
		}
	}
}
