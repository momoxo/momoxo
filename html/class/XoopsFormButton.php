<?php

/**
 * A button
 *
 * @author	Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 *
 * @package     kernel
 * @subpackage  form
 */
class XoopsFormButton extends XoopsFormElement {

	/**
     * Value
	 * @var	string
	 * @access	private
	 */
	var $_value;

	/**
     * Type of the button. This could be either "button", "submit", or "reset"
	 * @var	string
	 * @access	private
	 */
	var $_type;

	/**
	 * Constructor
     *
	 * @param	string  $caption    Caption
     * @param	string  $name
     * @param	string  $value
     * @param	string  $type       Type of the button.
     * This could be either "button", "submit", or "reset"
	 */
	function XoopsFormButton($caption, $name, $value="", $type="button"){
		$this->setCaption($caption);
		$this->setName($name);
		$this->_type = $type;
		$this->setValue($value);
	}

	/**
	 * Get the initial value
	 *
     * @return	string
	 */
	function getValue(){
		return $this->_value;
	}

	/**
	 * Set the initial value
	 *
     * @return	string
	 */
	function setValue($value){
		$this->_value = $value;
	}

	/**
	 * Get the type
	 *
     * @return	string
	 */
	function getType(){
		return $this->_type;
	}

	/**
	 * prepare HTML for output
	 *
     * @return	string
	 */
	function render(){
		$root =& XCube_Root::getSingleton();
		$renderSystem =& $root->getRenderSystem(XOOPSFORM_DEPENDENCE_RENDER_SYSTEM);
		
		$renderTarget =& $renderSystem->createRenderTarget('main');
	
		$renderTarget->setAttribute('xcore_module', 'xcore');
		$renderTarget->setTemplateName("xcore_xoopsform_button.html");
		$renderTarget->setAttribute("element", $this);

		$renderSystem->render($renderTarget);
	
		return $renderTarget->getResult();
	}
}
