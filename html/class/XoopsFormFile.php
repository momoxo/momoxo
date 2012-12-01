<?php

/**
 * A file upload field
 * 
 * @author	Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 * 
 * @package		kernel
 * @subpackage	form
 */
use XCore\Kernel\Root;

class XoopsFormFile extends XoopsFormElement {

	/**
     * Maximum size for an uploaded file
	 * @var	int	
	 * @access	private
	 */
	var $_maxFileSize;

	/**
	 * Constructor
	 * 
	 * @param	string	$caption		Caption
	 * @param	string	$name			"name" attribute
	 * @param	int		$maxfilesize	Maximum size for an uploaded file
	 */
	function XoopsFormFile($caption, $name, $maxfilesize){
		$this->setCaption($caption);
		$this->setName($name);
		$this->_maxFileSize = intval($maxfilesize);
	}

	/**
	 * Get the maximum filesize
	 * 
	 * @return	int
	 */
	function getMaxFileSize(){
		return $this->_maxFileSize;
	}

	/**
	 * prepare HTML for output
	 * 
	 * @return	string	HTML
	 */
	function render(){
		$root =& Root::getSingleton();
		$renderSystem =& $root->getRenderSystem(XOOPSFORM_DEPENDENCE_RENDER_SYSTEM);
		
		$renderTarget =& $renderSystem->createRenderTarget('main');
	
		$renderTarget->setAttribute('xcore_module', 'xcore');
		$renderTarget->setTemplateName("xcore_xoopsform_file.html");
		$renderTarget->setAttribute("element", $this);

		$renderSystem->render($renderTarget);
	
		return $renderTarget->getResult();
	}
}
