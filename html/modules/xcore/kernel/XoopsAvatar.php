<?php

class XoopsAvatar extends XoopsObject
{
    var $_userCount;

    function XoopsAvatar()
    {
        $this->XoopsObject();
        $this->initVar('avatar_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('avatar_file', XOBJ_DTYPE_OTHER, null, false, 30);
        $this->initVar('avatar_name', XOBJ_DTYPE_TXTBOX, null, true, 100);
        $this->initVar('avatar_mimetype', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('avatar_created', XOBJ_DTYPE_INT, null, false);
        $this->initVar('avatar_display', XOBJ_DTYPE_INT, 1, false);
        $this->initVar('avatar_weight', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('avatar_type', XOBJ_DTYPE_OTHER, 0, false);
    }

    function setUserCount($value)
    {
        $this->_userCount = (int)$value;
    }

    function getUserCount()
    {
        return $this->_userCount;
    }
}
