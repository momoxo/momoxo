<?php

use XCore\Kernel\Ref;
use XCore\Kernel\Delegate;

class Xcore_Module extends Xcore_ModuleAdapter
{
	function Xcore_Module(&$xoopsModule)
	{
		parent::Xcore_ModuleAdapter($xoopsModule);
		$this->mGetAdminMenu =new Delegate();
		$this->mGetAdminMenu->register('Xcore_Module.getAdminMenu');
	}
	
	function getAdminMenu()
	{
		$menu = parent::getAdminMenu();
		$this->mGetAdminMenu->call(new Ref($menu));
		
		ksort($menu);
		
		return $menu;
	}
}
