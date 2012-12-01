<?php

/**
 * Form that will output formatted as a HTML table
 * 
 * No styles and no JavaScript to check for required fields.
 * 
 * @author	Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 * 
 * @package     kernel
 * @subpackage  form
 */
use XCore\Kernel\Root;

class XoopsTableForm extends XoopsForm
{

	/**
	 * create HTML to output the form as a table
	 * 
     * @return	string
	 */
	function render()
	{
		$root =& Root::getSingleton();
		$renderSystem =& $root->getRenderSystem(XOOPSFORM_DEPENDENCE_RENDER_SYSTEM);
		
		$renderTarget =& $renderSystem->createRenderTarget('main');
	
		$renderTarget->setAttribute('xcore_module', 'xcore');
		$renderTarget->setTemplateName("xcore_xoopsform_tableform.html");
		$renderTarget->setAttribute("form", $this);

		$renderSystem->render($renderTarget);
	
		return $renderTarget->getResult();
	}
}
