<?php

/**
 * One or more Checkbox(es)
 * 
 * @package     kernel
 * @subpackage  form
 * 
 * @author	Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */
class XoopsFormCheckBox extends XoopsFormElement {

	/**
     * Availlable options
	 * @var array   
	 * @access	private
	 */
	var $_options = array();

	/**
     * pre-selected values in array
	 * @var	array   
	 * @access	private
	 */
	var $_value = array();

	/**
	 * Constructor
	 * 
     * @param	string  $caption
     * @param	string  $name
     * @param	mixed   $value  Either one value as a string or an array of them.   
	 */
	function XoopsFormCheckBox($caption, $name, $value = null){
		$this->setCaption($caption);
		$this->setName($name);
		if (isset($value)) {
			$this->setValue($value);
		}
	}

	/**
	 * Get the "value"
	 * 
     * @return	array
	 */
	function getValue(){
		return $this->_value;
	}

	/**
	 * Set the "value"
	 * 
     * @param	array
	 */
	function setValue($value){
		$this->_value = array();
		if (is_array($value)) {
			foreach ($value as $v) {
				$this->_value[] = $v;
			}
		} else {
			$this->_value[] = $value;
		}
	}

	/**
	 * Add an option
	 * 
     * @param	string  $value  
     * @param	string  $name   
	 */
	function addOption($value, $name=""){
		if ($name != "") {
			$this->_options[$value] = $name;
		} else {
			$this->_options[$value] = $value;
		}
	}

	/**
	 * Add multiple Options at once
	 * 
     * @param	array   $options    Associative array of value->name pairs
	 */
	function addOptionArray($options){
		if ( is_array($options) ) {
			foreach ( $options as $k=>$v ) {
				$this->addOption($k, $v);
			}
		}
	}

	/**
	 * Get an array with all the options
	 * 
     * @return	array   Associative array of value->name pairs
	 */
	function getOptions(){
		return $this->_options;
	}

	/**
	 * prepare HTML for output
	 * 
     * @return	string
	 */
	function render()
	{
		$root =& XCube_Root::getSingleton();
		$renderSystem =& $root->getRenderSystem(XOOPSFORM_DEPENDENCE_RENDER_SYSTEM);
		
		$renderTarget =& $renderSystem->createRenderTarget('main');
	
		if ( count($this->getOptions()) > 1 && substr($this->getName(), -2, 2) != "[]" ) {
			$newname = $this->getName()."[]";
			$this->setName($newname);
		}
		
		$renderTarget->setAttribute('xcore_module', 'xcore');
		$renderTarget->setTemplateName("xcore_xoopsform_checkbox.html");
		$renderTarget->setAttribute("element", $this);

		$renderSystem->render($renderTarget);
		
		return $renderTarget->getResult();
	}
}
