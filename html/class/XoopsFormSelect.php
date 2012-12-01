<?php

/**
 * A select field
 * 
 * @package     kernel
 * @subpackage  form
 * 
 * @author	    Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */
use XCore\Kernel\Root;

class XoopsFormSelect extends XoopsFormElement {

	/**
     * Options
	 * @var array   
	 * @access	private
	 */
	var $_options = array();

	/**
     * Allow multiple selections?
	 * @var	bool    
	 * @access	private
	 */
	var $_multiple = false;

	/**
     * Number of rows. "1" makes a dropdown list.
	 * @var	int 
	 * @access	private
	 */
	var $_size;

	/**
     * Pre-selcted values
	 * @var	array   
	 * @access	private
	 */
	var $_value = array();

	/**
	 * Constructor
	 * 
	 * @param	string	$caption	Caption
	 * @param	string	$name       "name" attribute
	 * @param	mixed	$value	    Pre-selected value (or array of them).
	 * @param	int		$size	    Number or rows. "1" makes a drop-down-list
     * @param	bool    $multiple   Allow multiple selections?
	 */
	function XoopsFormSelect($caption, $name, $value=null, $size=1, $multiple=false){
		$this->setCaption($caption);
		$this->setName($name);
		$this->_multiple = $multiple;
		$this->_size = intval($size);
		if (isset($value)) {
			$this->setValue($value);
		}
	}

	/**
	 * Are multiple selections allowed?
	 * 
     * @return	bool
	 */
	function isMultiple(){
		return $this->_multiple;
	}

	/**
	 * Get the size
	 * 
     * @return	int
	 */
	function getSize(){
		return $this->_size;
	}

	/**
	 * Get an array of pre-selected values
	 * 
     * @return	array
	 */
	function getValue(){
		return $this->_value;
	}

	/**
	 * Set pre-selected values
	 * 
     * @param	$value	mixed
	 */
	function setValue($value){
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
	 * @param	string  $value  "value" attribute
     * @param	string  $name   "name" attribute
	 */
	function addOption($value, $name=""){
		if ( $name != "" ) {
			$this->_options[$value] = $name;
		} else {
			$this->_options[$value] = $value;
		}
	}

	/**
	 * Add multiple options
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
	 * Get all options
	 * 
     * @return	array   Associative array of value->name pairs
	 */
	function getOptions(){
		return $this->_options;
	}

	/**
	 * Prepare HTML for output
	 * 
     * @return	string  HTML
	 */
	function render(){
		$root = Root::getSingleton();
		$renderSystem =& $root->getRenderSystem(XOOPSFORM_DEPENDENCE_RENDER_SYSTEM);
		
		$renderTarget =& $renderSystem->createRenderTarget('main');
	
		$renderTarget->setAttribute('xcore_module', 'xcore');
		$renderTarget->setTemplateName("xcore_xoopsform_select.html");
		$renderTarget->setAttribute("element", $this);

		$renderSystem->render($renderTarget);
	
		return $renderTarget->getResult();
	}
}
