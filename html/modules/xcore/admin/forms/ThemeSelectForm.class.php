<?php
/**
 *
 * @package Xcore
 * @version $Id: ThemeSelectForm.class.php,v 1.4 2008/09/25 15:11:20 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momonga-project/momonga>
 * @license https://github.com/momonga-project/momonga/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/modules/xcore/kernel/XCube_ActionForm.class.php";

/***
 * @internal
 * This class is generated by makeActionForm tool.
 */
class Xcore_ThemeSelectForm extends XCube_ActionForm
{
	function getTokenName()
	{
		return "module.xcore.ThemeSelectForm.TOKEN";
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['select'] =new XCube_BoolArrayProperty('select');
		$this->mFormProperties['choose'] =new XCube_StringArrayProperty('choose');
	}

	/**
	 * @access public
	 */
	function getChooseTheme()
	{
		foreach ($this->get('choose') as $dirname => $dmy) {
			return $dirname;
		}
		
		return null;
	}
	
	function getSelectableTheme()
	{
		$ret = array();
		
		foreach ($this->get('select') as $themeName => $isSelect) {
			if ($isSelect == 1) {
				$ret[] = $themeName;
			}
		}
		
		return $ret;
	}
	
	function load(&$themeArr)
	{
		foreach ($themeArr as $themeName) {
			$this->set('select', $themeName, 1);
		}
	}
}

?>