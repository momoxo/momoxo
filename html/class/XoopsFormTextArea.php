<?php

/**
 * A textarea
 * 
 * @author	Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 * 
 * @package     kernel
 * @subpackage  form
 */
use XCore\Kernel\Root;

class XoopsFormTextArea extends XoopsFormElement {
	/**
     * number of columns
	 * @var	int 
	 * @access  private
	 */
	var $_cols;

	/**
	 * number of rows
     * @var	int 
	 * @access  private
	 */
	var $_rows;

	/**
     * initial content
	 * @var	string  
	 * @access  private
	 */
	var $_value;

	/**
	 * Constuctor
	 * 
     * @param	string  $caption    caption
     * @param	string  $name       name
     * @param	string  $value      initial content
     * @param	int     $rows       number of rows
     * @param	int     $cols       number of columns   
	 */
	function XoopsFormTextArea($caption, $name, $value="", $rows=5, $cols=50){
		$this->setCaption($caption);
		$this->setName($name);
		$this->_rows = intval($rows);
		$this->_cols = intval($cols);
		$this->setValue($value);
	}

	/**
	 * get number of rows
	 * 
     * @return	int
	 */
	function getRows(){
		return $this->_rows;
	}

	/**
	 * Get number of columns
	 * 
     * @return	int
	 */
	function getCols(){
		return $this->_cols;
	}

	/**
	 * Get initial content
	 * 
     * @return	string
	 */
	function getValue(){
		return $this->_value;
	}

	/**
	 * Set initial content
	 * 
     * @param	$value	string
	 */
	function setValue($value){
		$this->_value = $value;
	}

	/**
	 * prepare HTML for output
	 * 
     * @return	sting HTML
	 */
	function render(){
		$root =& Root::getSingleton();
		$renderSystem =& $root->getRenderSystem(XOOPSFORM_DEPENDENCE_RENDER_SYSTEM);
		
		$renderTarget =& $renderSystem->createRenderTarget();
	
		$renderTarget->setAttribute('xcore_module', 'xcore');
		$renderTarget->setTemplateName("xcore_xoopsform_textarea.html");
		$renderTarget->setAttribute("element", $this);
		$renderTarget->setAttribute("class", $this->getClass());

		$renderSystem->render($renderTarget);
	
		return $renderTarget->getResult();
	}
}
