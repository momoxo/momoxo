<?php

/**
 * A simple text field
 * 
 * @package     kernel
 * @subpackage  form
 * 
 * @author	    Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */
use XCore\Kernel\Root;

class XoopsFormText extends XoopsFormElement {

	/**
     * Size
	 * @var	int 
     * @access	private
	 */
	var $_size;

	/**
     * Maximum length of the text
	 * @var	int 
	 * @access	private
	 */
	var $_maxlength;

	/**
     * Initial text
	 * @var	string  
	 * @access	private
	 */
	var $_value;

	/**
	 * Constructor
	 * 
	 * @param	string	$caption	Caption
	 * @param	string	$name       "name" attribute
	 * @param	int		$size	    Size
	 * @param	int		$maxlength	Maximum length of text
     * @param	string  $value      Initial text
	 */
	function XoopsFormText($caption, $name, $size, $maxlength, $value=""){
		$this->setCaption($caption);
		$this->setName($name);
		$this->_size = intval($size);
		$this->_maxlength = intval($maxlength);
		$this->setValue($value);
	}

	/**
	 * Get size
	 * 
     * @return	int
	 */
	function getSize(){
		return $this->_size;
	}

	/**
	 * Get maximum text length
	 * 
     * @return	int
	 */
	function getMaxlength(){
		return $this->_maxlength;
	}

	/**
	 * Get initial text value
	 * 
     * @return  string
	 */
	function getValue(){
		return $this->_value;
	}

	/**
	 * Set initial text value
	 * 
     * @param	$value  string
	 */
	function setValue($value){
		$this->_value = $value;
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
		$renderTarget->setTemplateName("xcore_xoopsform_text.html");
		$renderTarget->setAttribute("element", $this);

		$renderSystem->render($renderTarget);
	
		return $renderTarget->getResult();
	}
}
