<?php

/**
 * A password field
 * 
 * @author	Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 * 
 * @package     kernel
 * @subpackage  form
 */
use XCore\Kernel\Root;

class XoopsFormPassword extends XoopsFormElement {

	/**
     * Size of the field.
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
     * Initial content of the field.
	 * @var	string	
	 * @access	private
	 */
	var $_value;

	/**
	 * Constructor
	 * 
	 * @param	string	$caption	Caption
	 * @param	string	$name		"name" attribute
	 * @param	int		$size		Size of the field
	 * @param	int		$maxlength	Maximum length of the text
	 * @param	int		$value		Initial value of the field. 
	 * 								<b>Warning:</b> this is readable in cleartext in the page's source!
	 */
	function XoopsFormPassword($caption, $name, $size, $maxlength, $value=""){
		$this->setCaption($caption);
		$this->setName($name);
		$this->_size = intval($size);
		$this->_maxlength = intval($maxlength);
		$this->setValue($value);
	}

	/**
	 * Get the field size
	 * 
	 * @return	int
	 */
	function getSize(){
		return $this->_size;
	}

	/**
	 * Get the max length
	 * 
	 * @return	int
	 */
	function getMaxlength(){
		return $this->_maxlength;
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
	 * @patam	$value	string
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
		$root = Root::getSingleton();
		$renderSystem =& $root->getRenderSystem(XOOPSFORM_DEPENDENCE_RENDER_SYSTEM);
		
		$renderTarget =& $renderSystem->createRenderTarget('main');
	
		$renderTarget->setAttribute('xcore_module', 'xcore');
		$renderTarget->setTemplateName("xcore_xoopsform_password.html");
		$renderTarget->setAttribute("element", $this);

		$renderSystem->render($renderTarget);
	
		return $renderTarget->getResult();
	}
}
