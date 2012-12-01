<?php

/**
 * A hidden field
 * 
 * @package     kernel
 * @subpackage  form
 * 
 * @author	    Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */
use XCore\Kernel\Root;

class XoopsFormHidden extends XoopsFormElement {

	/**
     * Value
	 * @var	string	
	 * @access	private
	 */
	var $_value;

	/**
	 * Constructor
	 * 
	 * @param	string	$name	"name" attribute
	 * @param	string	$value	"value" attribute
	 */
	function XoopsFormHidden($name, $value){
		$this->setName($name);
		$this->setHidden();
		$this->setValue($value);
		$this->setCaption("");
	}

	/**
	 * Get the "value" attribute
	 * 
	 * @return	string
	 */
	function getValue(){
		return $this->_value;
	}

	/**
	 * Sets the "value" attribute
	 * 
	 * @patam  $value	string
	 */
	function setValue($value){
		$this->_value = $value;
	}

	/**
	 * Prepare HTML for output
	 * 
	 * @return	string	HTML
	 */
	function render(){
		$root =& Root::getSingleton();
		$renderSystem =& $root->getRenderSystem(XOOPSFORM_DEPENDENCE_RENDER_SYSTEM);
		
		$renderTarget =& $renderSystem->createRenderTarget('main');
	
		$renderTarget->setAttribute('xcore_module', 'xcore');
		$renderTarget->setTemplateName("xcore_xoopsform_hidden.html");
		$renderTarget->setAttribute("element", $this);

		$renderSystem->render($renderTarget);
	
		return $renderTarget->getResult();
	}
}
