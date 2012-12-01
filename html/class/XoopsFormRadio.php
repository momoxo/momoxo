<?php

/**
 * A Group of radiobuttons
 * 
 * @author	Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 * 
 * @package		kernel
 * @subpackage	form
 */
use XCore\Kernel\Root;

class XoopsFormRadio extends XoopsFormElement {

	/**
     * Array of Options
	 * @var	array	
	 * @access	private
	 */
	var $_options = array();

	/**
     * Pre-selected value
	 * @var	string	
	 * @access	private
	 */
	var $_value = null;

	/**
	 * Constructor
	 * 
	 * @param	string	$caption	Caption
	 * @param	string	$name		"name" attribute
	 * @param	string	$value		Pre-selected value
	 */
	function XoopsFormRadio($caption, $name, $value = null){
		$this->setCaption($caption);
		$this->setName($name);
		if (isset($value)) {
			$this->setValue($value);
		}
	}

	/**
	 * Get the pre-selected value
	 * 
	 * @return	string
	 */
	function getValue(){
		return $this->_value;
	}

	/**
	 * Set the pre-selected value
	 * 
	 * @param	$value	string
	 */
	function setValue($value){
		$this->_value = $value;
	}

	/**
	 * Add an option
	 * 
	 * @param	string	$value	"value" attribute - This gets submitted as form-data.
	 * @param	string	$name	"name" attribute - This is displayed. If empty, we use the "value" instead.
	 */
	function addOption($value, $name=""){
		if ( $name != "" ) {
			$this->_options[$value] = $name;
		} else {
			$this->_options[$value] = $value;
		}
	}

	/**
	 * Adds multiple options
	 * 
	 * @param	array	$options	Associative array of value->name pairs.
	 */
	function addOptionArray($options){
		if ( is_array($options) ) {
			foreach ( $options as $k=>$v ) {
				$this->addOption($k, $v);
			}
		}
	}

	/**
	 * Gets the options
	 * 
	 * @return	array	Associative array of value->name pairs.
	 */
	function getOptions(){
		return $this->_options;
	}

	/**
	 * Prepare HTML for output
	 * 
	 * @return	string	HTML
	 */
	function render(){
		$root =& Root::getSingleton();
		$renderSystem =& $root->getRenderSystem(XOOPSFORM_DEPENDENCE_RENDER_SYSTEM);
		
		$renderTarget =& $renderSystem->createRenderTarget();
	
		$renderTarget->setAttribute('xcore_module', 'xcore');
		$renderTarget->setTemplateName("xcore_xoopsform_radio.html");
		$renderTarget->setAttribute("element", $this);

		$renderSystem->render($renderTarget);
	
		return $renderTarget->getResult();
	}
}
