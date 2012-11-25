<?php

/**
 * A Comment
 * 
 * @package     kernel
 * 
 * @author	    Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */
class XoopsComment extends XoopsObject
{

    /**
     * Constructor
     **/
    function XoopsComment()
    {
        $this->XoopsObject();
        $this->initVar('com_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('com_pid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('com_modid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('com_icon', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('com_title', XOBJ_DTYPE_TXTBOX, null, true, 255, true);
        $this->initVar('com_text', XOBJ_DTYPE_TXTAREA, null, true, null, true);
        $this->initVar('com_created', XOBJ_DTYPE_INT, time(), false);
        $this->initVar('com_modified', XOBJ_DTYPE_INT, time(), false);
        $this->initVar('com_uid', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('com_ip', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('com_sig', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('com_itemid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('com_rootid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('com_status', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('com_exparams', XOBJ_DTYPE_OTHER, null, false, 255);
        $this->initVar('dohtml', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('dosmiley', XOBJ_DTYPE_INT, 1, false);
        $this->initVar('doxcode', XOBJ_DTYPE_INT, 1, false);
        $this->initVar('doimage', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('dobr', XOBJ_DTYPE_INT, 1, false);
    }

	/**
	 * Is this comment on the root level?
	 * 
	 * @return  bool
	 **/
	function isRoot()
    {
        return ($this->getVar('com_id') == $this->getVar('com_rootid'));
    }
    
	/**
	 * Create a responce comment object, and return it.
	 * @return XoopsComment
	 */
    function &createChild()
    {
		$ret=new XoopsComment();
		$ret->setNew();
		$ret->setVar('com_pid',$this->getVar('com_id'));
		$ret->setVar('com_rootid',$this->getVar('com_rootid'));
		$ret->setVar('com_modid',$this->getVar('com_modid'));
		$ret->setVar('com_itemid',$this->getVar('com_itemid'));
		$ret->setVar('com_exparams',$this->getVar('com_exparams'));

		$title = $this->get('com_title');
		if (preg_match("/^Re:(.+)$/", $title, $matches)) {
			$ret->set('com_title', "Re[2]: " . $matches[1]);
		}
		elseif (preg_match("/^Re\[(\d+)\]:(.+)$/", $title, $matches)) {
			$ret->set('com_title', "Re[" . ($matches[1] + 1) . "]: " . $matches[2]);
		}
		elseif (!preg_match("/^re:/i", $title)) {
			$ret->set('com_title', "Re: ".xoops_substr($title, 0, 56) );
		} else {
			$ret->set('com_title', $title );
		}

		return $ret;
	}
}
