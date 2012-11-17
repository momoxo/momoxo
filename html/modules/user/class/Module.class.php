<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

class User_Module extends Xcore_ModuleAdapter
{
	function User_Module(&$xoopsModule)
	{
		parent::Xcore_ModuleAdapter($xoopsModule);
		$this->mGetAdminMenu =new XCube_Delegate();
		$this->mGetAdminMenu->register('User_Module.getAdminMenu');
	}
	
	function getAdminMenu()
	{
		$menu = parent::getAdminMenu();
		$this->mGetAdminMenu->call(new XCube_Ref($menu));
		
		ksort($menu);
		
		return $menu;
	}
}

?>
