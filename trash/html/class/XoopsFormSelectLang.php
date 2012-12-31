<?php

/**
 * A select field with available languages
 * 
 * @package     kernel
 * @subpackage  form
 * 
 * @author	    Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */
class XoopsFormSelectLang extends XoopsFormSelect
{
	/**
	 * Constructor
	 * 
	 * @param	string	$caption
	 * @param	string	$name
	 * @param	mixed	$value	Pre-selected value (or array of them).
	 * 							Legal is any name of a XOOPS_ROOT_PATH."/language/" subdirectory.
	 * @param	int		$size	Number of rows. "1" makes a drop-down-list.
	 */
	function XoopsFormSelectLang($caption, $name, $value=null, $size=1)
	{
		$this->XoopsFormSelect($caption, $name, $value, $size);
		$this->addOptionArray(XoopsLists::getLangList());
	}
}
