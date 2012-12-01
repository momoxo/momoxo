<?php

/**
 * A text label
 * 
 * @package     kernel
 * @subpackage  form
 * 
 * @author	    Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */
use XCore\Kernel\Root;

class XoopsFormLabel extends XoopsFormElement {

	/**
     * Text
	 * @var	string	
	 * @access	private
	 */
	var $_value;

	/**
	 * Constructor
	 * 
	 * @param	string	$caption	Caption
	 * @param	string	$value		Text
	 */
	function XoopsFormLabel($caption="", $value=""){
		$this->setCaption($caption);
		$this->_value = $value;
	}

	/**
	 * Get the text
	 * 
	 * @return	string
	 */
	function getValue(){
		return $this->_value;
	}

	/**
	 * Prepare HTML for output
	 * 
	 * @return	string
	 */
	function render(){
		$root =& Root::getSingleton();
		$renderSystem =& $root->getRenderSystem(XOOPSFORM_DEPENDENCE_RENDER_SYSTEM);
		
		$renderTarget =& $renderSystem->createRenderTarget('main');
	
		$renderTarget->setAttribute('xcore_module', 'xcore');
		$renderTarget->setTemplateName("xcore_xoopsform_label.html");
		$renderTarget->setAttribute("element", $this);

		$renderSystem->render($renderTarget);
	
		return $renderTarget->getResult();
	}
}
