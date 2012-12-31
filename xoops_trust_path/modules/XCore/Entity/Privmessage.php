<?php


namespace XCore\Entity;

/**
 * {description}
 *
 * @package		kernel
 *
 * @author		Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 The XOOPS Project (http://www.xoops.org)
 *
 * @version		$Revision: 1.1 $ - $Date: 2007/05/15 02:34:38 $
 */
use XCore\Entity\Object;

class Privmessage extends Object
{

/**
 * constructor
 **/
    function __construct()
    {
        parent::__construct();
        $this->initVar('msg_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('msg_image', XOBJ_DTYPE_OTHER, 'icon1.gif', false, 100);
        $this->initVar('subject', XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar('from_userid', XOBJ_DTYPE_INT, null, true);
        $this->initVar('to_userid', XOBJ_DTYPE_INT, null, true);
        $this->initVar('msg_time', XOBJ_DTYPE_OTHER, time(), false);
        $this->initVar('msg_text', XOBJ_DTYPE_TXTAREA, null, true);
        $this->initVar('read_msg', XOBJ_DTYPE_INT, 0, false);
    }
    
    function &getFromUser()
    {
		$userHandler=xoops_gethandler('user');
		$user=&$userHandler->get($this->getVar('from_userid'));
		return $user;
	}
	
	function isRead()
	{
		return $this->getVar('read_msg')==1 ? true : false;
	}
}
