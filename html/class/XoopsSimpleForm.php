<?php

/**
 * Form that will output as a simple HTML form with minimum formatting
 * 
 * @author	Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 * 
 * @package     kernel
 * @subpackage  form
 */
use XCore\Kernel\Root;

class XoopsSimpleForm extends XoopsForm
{
	/**
	 * create HTML to output the form with minimal formatting
	 * 
     * @return	string
	 */
	function render()
	{
		$root = Root::getSingleton();
		$renderSystem =& $root->getRenderSystem(XOOPSFORM_DEPENDENCE_RENDER_SYSTEM);
		
		$renderTarget =& $renderSystem->createRenderTarget('main');
	
		$renderTarget->setAttribute('xcore_module', 'xcore');
		$renderTarget->setTemplateName("xcore_xoopsform_simpleform.html");
		$renderTarget->setAttribute("form", $this);

		$renderSystem->render($renderTarget);
	
		return $renderTarget->getResult();
	}
}
