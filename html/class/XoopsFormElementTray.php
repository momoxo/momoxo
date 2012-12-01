<?php

/**
 * A group of form elements
 * 
 * @author	Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 * 
 * @package     kernel
 * @subpackage  form
 */
use XCore\Kernel\Root;

class XoopsFormElementTray extends XoopsFormElement {

	/**
     * array of form element objects
	 * @var array   
     * @access  private
	 */
	var $_elements = array();

	/**
     * required elements
	 * @var array   
	 */
	var $_required = array();

	/**
     * HTML to seperate the elements
	 * @var	string  
	 * @access  private
	 */
	var $_delimeter;

	/**
	 * constructor
	 * 
     * @param	string  $caption    Caption for the group.
     * @param	string  $delimiter  HTML to separate the elements
	 */
	function XoopsFormElementTray($caption, $delimeter="&nbsp;", $name=""){
	    $this->setName($name);
		$this->setCaption($caption);
		$this->_delimeter = $delimeter;
	}

	/**
	 * Is this element a container of other elements?
	 * 
     * @return	bool true
	 */	
	function isContainer()
	{
		return true;
	}

	/**
	 * Add an element to the group
	 * 
     * @param	object  &$element    {@link XoopsFormElement} to add
	 */
	function addElement(&$formElement, $required=false){
		$this->_elements[] =& $formElement;
		if ($required) {
			if (!$formElement->isContainer()) {
				$this->_required[] =& $formElement;
			} else {
				$required_elements =& $formElement->getElements(true);
				$count = count($required_elements);
				for ($i = 0 ; $i < $count; $i++) {
					$this->_required[] =& $required_elements[$i];
				}
			}
		}
	}

	/**
	 * get an array of "required" form elements
	 * 
     * @return	array   array of {@link XoopsFormElement}s 
	 */
	function &getRequired()
	{
		return $this->_required;
	}

	/**
	 * Get an array of the elements in this group
	 * 
	 * @param	bool	$recurse	get elements recursively?
     * @return  array   Array of {@link XoopsFormElement} objects. 
	 */
	function &getElements($recurse = false){
		if (!$recurse) {
			return $this->_elements;
		} else {
			$ret = array();
			$count = count($this->_elements);
			for ($i = 0; $i < $count; $i++) {
				if (!$this->_elements[$i]->isContainer()) {
					$ret[] =& $this->_elements[$i];
				} else {
					$elements =& $this->_elements[$i]->getElements(true);
					$count2 = count($elements);
					for ($j = 0; $j < $count2; $j++) {
						$ret[] =& $elements[$j];
					}
					unset($elements);
				}
			}
			return $ret;
		}
	}

	/**
	 * Get the delimiter of this group
	 * 
     * @return	string  The delimiter
	 */
	function getDelimeter(){
		return $this->_delimeter;
	}

	/**
	 * prepare HTML to output this group
	 * 
     * @return	string  HTML output
	 */
	function render(){
		$root =& Root::getSingleton();
		$renderSystem =& $root->getRenderSystem(XOOPSFORM_DEPENDENCE_RENDER_SYSTEM);
		
		$renderTarget =& $renderSystem->createRenderTarget('main');
	
		$renderTarget->setAttribute('xcore_module', 'xcore');
		$renderTarget->setTemplateName("xcore_xoopsform_elementtray.html");
		$renderTarget->setAttribute("tray", $this);

		$renderSystem->render($renderTarget);
	
		return $renderTarget->getResult();
	}
}
