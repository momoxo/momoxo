<?php

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
