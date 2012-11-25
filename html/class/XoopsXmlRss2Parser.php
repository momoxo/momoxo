<?php

class XoopsXmlRss2Parser extends SaxParser
{
    var $_tempArr = array();
    var $_channelData = array();
    var $_imageData = array();
    var $_items = array();

    function XoopsXmlRss2Parser(&$input)
    {
        $this->SaxParser($input);
		$this->useUtfEncoding();
        $this->addTagHandler(new RssChannelHandler());
        $this->addTagHandler(new RssTitleHandler());
        $this->addTagHandler(new RssLinkHandler());
        $this->addTagHandler(new RssGeneratorHandler());
        $this->addTagHandler(new RssDescriptionHandler());
        $this->addTagHandler(new RssCopyrightHandler());
        $this->addTagHandler(new RssNameHandler());
        $this->addTagHandler(new RssManagingEditorHandler());
        $this->addTagHandler(new RssLanguageHandler());
        $this->addTagHandler(new RssLastBuildDateHandler());
        $this->addTagHandler(new RssWebMasterHandler());
        $this->addTagHandler(new RssImageHandler());
        $this->addTagHandler(new RssUrlHandler());
        $this->addTagHandler(new RssWidthHandler());
        $this->addTagHandler(new RssHeightHandler());
        $this->addTagHandler(new RssItemHandler());
        $this->addTagHandler(new RssCategoryHandler());
        $this->addTagHandler(new RssPubDateHandler());
        $this->addTagHandler(new RssCommentsHandler());
        $this->addTagHandler(new RssSourceHandler());
        $this->addTagHandler(new RssAuthorHandler());
        $this->addTagHandler(new RssGuidHandler());
        $this->addTagHandler(new RssTextInputHandler());
    }

	function setChannelData($name, &$value)
	{
		if (!isset($this->_channelData[$name])) {
			$this->_channelData[$name] =& $value;
		} else {
			$this->_channelData[$name] .= $value;
		}
	}

    function &getChannelData($name = null)
    {
        if (isset($name)) {
            if (isset($this->_channelData[$name])) {
                return $this->_channelData[$name];
            }
            $ret = false;
            return $ret;
        }
        return $this->_channelData;
    }

    function setImageData($name, &$value)
    {
        $this->_imageData[$name] =& $value;
    }

    function &getImageData($name = null)
    {
        if (isset($name)) {
            if (isset($this->_imageData[$name])) {
                return $this->_imageData[$name];
            }
            $ret = false;
            return $ret;
        }
        return $this->_imageData;
    }

    function setItems(&$itemarr)
    {
        $this->_items[] =& $itemarr;
    }

    function &getItems()
    {
        return $this->_items;
    }

    function setTempArr($name, &$value, $delim = '')
    {
        if (!isset($this->_tempArr[$name])) {
            $this->_tempArr[$name] =& $value;
        } else {
            $this->_tempArr[$name] .= $delim.$value;
        }
    }

    function getTempArr()
    {
        return $this->_tempArr;
    }

    function resetTempArr()
    {
        unset($this->_tempArr);
        $this->_tempArr = array();
    }
}
