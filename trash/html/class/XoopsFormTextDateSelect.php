<?php

/**
 * A text field with calendar popup
 *
 * @package     kernel
 * @subpackage  form
 *
 * @author      Kazumi Ono  <onokazu@xoops.org>
 * @copyright   copyright (c) 2000-2003 XOOPS.org
 */
use XCore\Kernel\Root;

class XoopsFormTextDateSelect extends XoopsFormText
{

    function XoopsFormTextDateSelect($caption, $name, $size = 15, $value= 0)
    {
        $value = !is_numeric($value) ? time() : intval($value);
        $this->XoopsFormText($caption, $name, $size, 25, $value);
    }

    function render()
    {
		$root = Root::getSingleton();
		$renderSystem =& $root->getRenderSystem(XOOPSFORM_DEPENDENCE_RENDER_SYSTEM);
		
		$renderTarget =& $renderSystem->createRenderTarget('main');
	
		$renderTarget->setAttribute('xcore_module', 'xcore');
		$renderTarget->setTemplateName("xcore_xoopsform_textdateselect.html");
		$renderTarget->setAttribute("element", $this);
		$renderTarget->setAttribute("date", date("Y-m-d", $this->getValue()));
		
        $jstime = formatTimestamp($this->getValue(), '"F j, Y H:i:s"');
        include_once XOOPS_ROOT_PATH.'/js/calendar/calendarjs.php';

		$renderSystem->render($renderTarget);
	
		return $renderTarget->getResult();
    }
}
