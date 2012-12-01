<?php

/**
 * A textarea with xoopsish formatting and smilie buttons
 *
 * @author  Kazumi Ono  <onokazu@xoops.org>
 * @copyright   copyright (c) 2000-2003 XOOPS.org
 *
 * @package     kernel
 * @subpackage  form
 */
use XCore\Kernel\Root;

class XoopsFormDhtmlTextArea extends XoopsFormTextArea
{
    /**
     * Hidden text
     * @var string
     * @access  private
     */
    var $_hiddenText;

    /**
     * Constructor
     *
     * @param   string  $caption    Caption
     * @param   string  $name       "name" attribute
     * @param   string  $value      Initial text
     * @param   int     $rows       Number of rows
     * @param   int     $cols       Number of columns
     * @param   string  $hiddentext Hidden Text
     */
    function XoopsFormDhtmlTextArea($caption, $name, $value, $rows=5, $cols=50, $hiddentext="xoopsHiddenText")
    {
        $this->XoopsFormTextArea($caption, $name, $value, $rows, $cols);
        $this->_xoopsHiddenText = $hiddentext;
    }

    /**
     * Prepare HTML for output
     *
     * @return  string  HTML
     */
    function render()
    {
		$root = Root::getSingleton();
		$renderSystem =& $root->getRenderSystem(XOOPSFORM_DEPENDENCE_RENDER_SYSTEM);
		
		$renderTarget =& $renderSystem->createRenderTarget('main');
	
		$renderTarget->setAttribute('xcore_module', 'xcore');
		$renderTarget->setTemplateName("xcore_xoopsform_dhtmltextarea.html");
		$renderTarget->setAttribute("element", $this);
		$renderTarget->setAttribute("class", $this->getClass());

		$renderSystem->render($renderTarget);
	
		$ret = $renderTarget->getResult();
        $ret .= $this->_renderSmileys();
		
		return $ret;
    }

    /**
     * prepare HTML for output of the smiley list.
     *
     * @return  string HTML
     */
    function _renderSmileys()
    {
		$handler =& xoops_getmodulehandler('smiles', 'xcore');
		$smilesArr =& $handler->getObjects(new Criteria('display', 1));
		
		$root = Root::getSingleton();
		$renderSystem =& $root->getRenderSystem(XOOPSFORM_DEPENDENCE_RENDER_SYSTEM);
		$renderTarget =& $renderSystem->createRenderTarget('main');
	
		$renderTarget->setAttribute('xcore_module', 'xcore');
		$renderTarget->setTemplateName("xcore_xoopsform_opt_smileys.html");
		$renderTarget->setAttribute("element", $this);
		$renderTarget->setAttribute("smilesArr", $smilesArr);

		$renderSystem->render($renderTarget);
		
		return $renderTarget->getResult();
    }
}
