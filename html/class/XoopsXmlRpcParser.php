<?php

/**
* Class RSS Parser
*
* This class offers methods to parse RSS Files
*
* @link      http://www.xoops.org/ Latest release of this class
* @package   XOOPS
* @copyright Copyright (c) 2001 xoops.org. All rights reserved.
* @author    Kazumi Ono <onokazu@xoops.org>
* @version   1.6 ($Date: 2007/05/15 02:34:53 $) $Revision: 1.1 $
* @access    public
*/
class XoopsXmlRpcParser extends SaxParser
{

    /**
    *
    *
    *
    *
    * @access private
    * @var    array
    */
    var $_param;

    /**
    *
    *
    *
    *
    * @access private
    * @var    string
    */
    var $_methodName;

    /**
    *
    *
    *
    *
    * @access private
    * @var    array
    */
    var $_tempName;

    /**
    *
    *
    *
    *
    * @access private
    * @var    array
    */
    var $_tempValue;

    /**
    *
    *
    *
    *
    * @access private
    * @var    array
    */
    var $_tempMember;

    /**
    *
    *
    *
    *
    * @access private
    * @var    array
    */
    var $_tempStruct;

    /**
    *
    *
    *
    *
    * @access private
    * @var    array
    */
    var $_tempArray;

    /**
    *
    *
    *
    *
    * @access private
    * @var    array
    */
    var $_workingLevel = array();


    /**
    * Constructor of the class
    *
    *
    *
    *
    * @access
    * @author
    * @see
    */
    function XoopsXmlRpcParser(&$input)
    {
        $this->SaxParser($input);
        $this->addTagHandler(new RpcMethodNameHandler());
        $this->addTagHandler(new RpcIntHandler());
        $this->addTagHandler(new RpcDoubleHandler());
        $this->addTagHandler(new RpcBooleanHandler());
        $this->addTagHandler(new RpcStringHandler());
        $this->addTagHandler(new RpcDateTimeHandler());
        $this->addTagHandler(new RpcBase64Handler());
        $this->addTagHandler(new RpcNameHandler());
        $this->addTagHandler(new RpcValueHandler());
        $this->addTagHandler(new RpcMemberHandler());
        $this->addTagHandler(new RpcStructHandler());
        $this->addTagHandler(new RpcArrayHandler());
    }

    /**
    * This Method starts the parsing of the specified RDF File. The File can be a local or a remote File.
    *
    * @access
    * @author
    * @param
    * @return
    * @see
    */
    function setTempName($name)
    {
        $this->_tempName[$this->getWorkingLevel()] = $name;
    }

    /**
    * This Method starts the parsing of the specified RDF File. The File can be a local or a remote File.
    *
    * @access
    * @author
    * @param
    * @return
    * @see
    */
    function getTempName()
    {
        return $this->_tempName[$this->getWorkingLevel()];
    }

    /**
    * This Method starts the parsing of the specified RDF File. The File can be a local or a remote File.
    *
    * @access
    * @author
    * @param
    * @return
    * @see
    */
    function setTempValue($value)
    {
        if (is_array($value)) {
            settype($this->_tempValue, 'array');
            foreach ($value as $k => $v) {
                $this->_tempValue[$k] = $v;
            }
        } elseif (is_string($value)) {
            if (isset($this->_tempValue)) {
                if (is_string($this->_tempValue)) {
                    $this->_tempValue .= $value;
                }
            } else {
                $this->_tempValue = $value;
            }
        } else {
            $this->_tempValue = $value;
        }
    }

    /**
    * This Method starts the parsing of the specified RDF File. The File can be a local or a remote File.
    *
    * @access
    * @author
    * @param
    * @return
    * @see
    */
    function getTempValue()
    {
        return $this->_tempValue;
    }

    /**
    * This Method starts the parsing of the specified RDF File. The File can be a local or a remote File.
    *
    * @access
    * @author
    * @param
    * @return
    * @see
    */
    function resetTempValue()
    {
        unset($this->_tempValue);
    }

    /**
    * This Method starts the parsing of the specified RDF File. The File can be a local or a remote File.
    *
    * @access
    * @author
    * @param
    * @return
    * @see
    */
    function setTempMember($name, $value)
    {
        $this->_tempMember[$this->getWorkingLevel()][$name] = $value;
    }

    /**
    * This Method starts the parsing of the specified RDF File. The File can be a local or a remote File.
    *
    * @access
    * @author
    * @param
    * @return
    * @see
    */
    function getTempMember()
    {
        return $this->_tempMember[$this->getWorkingLevel()];
    }

    /**
    * This Method starts the parsing of the specified RDF File. The File can be a local or a remote File.
    *
    * @access
    * @author
    * @param
    * @return
    * @see
    */
    function resetTempMember()
    {
        $this->_tempMember[$this->getCurrentLevel()] = array();
    }

    /**
    * This Method starts the parsing of the specified RDF File. The File can be a local or a remote File.
    *
    * @access
    * @author
    * @param
    * @return
    * @see
    */
    function setWorkingLevel()
    {
        array_push($this->_workingLevel, $this->getCurrentLevel());
    }

    /**
    * This Method starts the parsing of the specified RDF File. The File can be a local or a remote File.
    *
    * @access
    * @author
    * @param
    * @return
    * @see
    */
    function getWorkingLevel()
    {
        return $this->_workingLevel[count($this->_workingLevel) - 1];
    }

    /**
    * This Method starts the parsing of the specified RDF File. The File can be a local or a remote File.
    *
    * @access
    * @author
    * @param
    * @return
    * @see
    */
    function releaseWorkingLevel()
    {
        array_pop($this->_workingLevel);
    }

    /**
    * This Method starts the parsing of the specified RDF File. The File can be a local or a remote File.
    *
    * @access
    * @author
    * @param
    * @return
    * @see
    */
    function setTempStruct($member)
    {
        $key = key($member);
        $this->_tempStruct[$this->getWorkingLevel()][$key] = $member[$key];
    }

    /**
    * This Method starts the parsing of the specified RDF File. The File can be a local or a remote File.
    *
    * @access
    * @author
    * @param
    * @return
    * @see
    */
    function getTempStruct()
    {
        return $this->_tempStruct[$this->getWorkingLevel()];
    }

    /**
    * This Method starts the parsing of the specified RDF File. The File can be a local or a remote File.
    *
    * @access
    * @author
    * @param
    * @return
    * @see
    */
    function resetTempStruct()
    {
        $this->_tempStruct[$this->getCurrentLevel()] = array();
    }

    /**
    * This Method starts the parsing of the specified RDF File. The File can be a local or a remote File.
    *
    * @access
    * @author
    * @param
    * @return
    * @see
    */
    function setTempArray($value)
    {
        $this->_tempArray[$this->getWorkingLevel()][] = $value;
    }

    /**
    * This Method starts the parsing of the specified RDF File. The File can be a local or a remote File.
    *
    * @access
    * @author
    * @param
    * @return
    * @see
    */
    function getTempArray()
    {
        return $this->_tempArray[$this->getWorkingLevel()];
    }

    /**
    * This Method starts the parsing of the specified RDF File. The File can be a local or a remote File.
    *
    * @access
    * @author
    * @param
    * @return
    * @see
    */
    function resetTempArray()
    {
        $this->_tempArray[$this->getCurrentLevel()] = array();
    }

    /**
    * This Method starts the parsing of the specified RDF File. The File can be a local or a remote File.
    *
    * @access
    * @author
    * @param
    * @return
    * @see
    */
    function setMethodName($methodName)
    {
        $this->_methodName = $methodName;
    }

    /**
    * This Method starts the parsing of the specified RDF File. The File can be a local or a remote File.
    *
    * @access
    * @author
    * @param
    * @return
    * @see
    */
    function getMethodName()
    {
        return $this->_methodName;
    }

    /**
    * This Method starts the parsing of the specified RDF File. The File can be a local or a remote File.
    *
    * @access
    * @author
    * @param
    * @return
    * @see
    */
    function setParam($value)
    {
        $this->_param[] = $value;
    }

    /**
    * This Method starts the parsing of the specified RDF File. The File can be a local or a remote File.
    *
    * @access
    * @author
    * @param
    * @return
    * @see
    */
    function &getParam()
    {
        return $this->_param;
    }
}
