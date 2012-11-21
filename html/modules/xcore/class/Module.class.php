<?php

class Xcore_Module extends Xcore_ModuleAdapter
{
	function Xcore_Module(&$xoopsModule)
	{
		parent::Xcore_ModuleAdapter($xoopsModule);
		$this->mGetAdminMenu =new XCube_Delegate();
		$this->mGetAdminMenu->register('Xcore_Module.getAdminMenu');
	}
	
	function getAdminMenu()
	{
		$menu = parent::getAdminMenu();
		$this->mGetAdminMenu->call(new XCube_Ref($menu));
		
		ksort($menu);
		
		return $menu;
	}
}
