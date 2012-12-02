<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

use XCore\Kernel\Root;
use XCore\Kernel\ActionFilter;

if (!defined('XOOPS_ROOT_PATH')) exit();

class User_MailjobPreload extends ActionFilter
{
	/**
	 * @public
	 */
	function preBlockFilter()
	{
		$root = Root::getSingleton();
	
		require_once XOOPS_MODULE_PATH . "/user/service/MailjobService.class.php";
		$service =new User_MailjobService();
		$service->prepare();
	
		$this->mRoot->mServiceManager->addService('User_MailjobService', $service);
	}
}

?>
