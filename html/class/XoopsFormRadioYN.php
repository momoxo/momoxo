<?php

/**
 * Yes/No radio buttons.
 * 
 * A pair of radio buttons labelled _YES and _NO with values 1 and 0
 * 
 * @package     kernel
 * @subpackage  form
 * 
 * @author	    Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */
class XoopsFormRadioYN extends XoopsFormRadio
{
	/**
	 * Constructor
	 * 
	 * @param	string	$caption
	 * @param	string	$name
	 * @param	string	$value		Pre-selected value, can be "0" (No) or "1" (Yes)
	 * @param	string	$yes		String for "Yes"
	 * @param	string	$no			String for "No"
	 */
	function XoopsFormRadioYN($caption, $name, $value=null, $yes=_YES, $no=_NO)
	{
		$this->XoopsFormRadio($caption, $name, $value);
		$this->addOption(1, $yes);
		$this->addOption(0, $no);
	}
}
