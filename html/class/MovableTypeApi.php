<?php

class MovableTypeApi extends XoopsXmlRpcApi
{
    function MovableTypeApi(&$params, &$response, &$module)
    {
        $this->XoopsXmlRpcApi($params, $response, $module);
    }

    function getCategoryList()
    {
        if (!$this->_checkUser($this->params[1], $this->params[2])) {
            $this->response->add(new XoopsXmlRpcFault(104));
        } else {
            $xoopsapi =& $this->_getXoopsApi($this->params);
            $xoopsapi->_setUser($this->user, $this->isadmin);
            $ret =& $xoopsapi->getCategories(false);
            if (is_array($ret)) {
                $arr = new XoopsXmlRpcArray();
                foreach ($ret as $id => $name) {
                    $struct = new XoopsXmlRpcStruct();
                    $struct->add('categoryId', new XoopsXmlRpcString($id));
                    $struct->add('categoryName', new XoopsXmlRpcString($name['title']));
                    $arr->add($struct);
                    unset($struct);
                }
                $this->response->add($arr);
            } else {
                $this->response->add(new XoopsXmlRpcFault(106));
            }
        }
    }

    function getPostCategories()
    {
        $this->response->add(new XoopsXmlRpcFault(107));
    }

    function setPostCategories()
    {
        $this->response->add(new XoopsXmlRpcFault(107));
    }

    function supportedMethods()
    {
        $this->response->add(new XoopsXmlRpcFault(107));
    }
}
