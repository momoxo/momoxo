<?php

use XCore\Kernel\Ref;
use XCore\Kernel\Delegate;

if (!defined('XOOPS_ROOT_PATH')) exit();

class User_Module extends Xcore_ModuleAdapter
{
	function User_Module(&$xoopsModule)
	{
		parent::Xcore_ModuleAdapter($xoopsModule);
		$this->mGetAdminMenu =new Delegate();
		$this->mGetAdminMenu->register('User_Module.getAdminMenu');
	}
	
	function getAdminMenu()
	{
		$menu = parent::getAdminMenu();
		$this->mGetAdminMenu->call(new Ref($menu));
		
		ksort($menu);
		
		return $menu;
	}
}

?>
