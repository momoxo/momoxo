<?php

/**
 * Form that will output as a theme-enabled HTML table
 * 
 * Also adds JavaScript to validate required fields
 * 
 * @author	Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 * 
 * @package     kernel
 * @subpackage  form
 */
use XCore\Kernel\Root;

class XoopsThemeForm extends XoopsForm
{
	/**
	 * Insert an empty row in the table to serve as a seperator.
	 * 
     * @param	string  $extra  HTML to be displayed in the empty row.
	 * @param	string	$class	CSS class name for <td> tag
	 */
	function insertBreak($extra = '', $class= '')
	{
    	$class = ($class != '') ? " class='$class'" : '';
    	$extra = ($extra != '') ? $extra : '&nbsp';
	    $this->addElement(new XoopsFormBreak($extra, $class)) ;
	}
	
	/**
	 * create HTML to output the form as a theme-enabled table with validation.
     * 
	 * @return	string
	 */
	function render()
	{
		$root =& Root::getSingleton();
		$renderSystem =& $root->getRenderSystem(XOOPSFORM_DEPENDENCE_RENDER_SYSTEM);
		$renderTarget =& $renderSystem->createRenderTarget('main');
	
		$renderTarget->setAttribute('xcore_module', 'xcore');
		$renderTarget->setTemplateName("xcore_xoopsform_themeform.html");
		$renderTarget->setAttribute("form", $this);

		$renderSystem->render($renderTarget);
	
		$ret = $renderTarget->getResult();
		$ret .= $this->renderValidationJS( true );
		
		return $ret;
	}
}
