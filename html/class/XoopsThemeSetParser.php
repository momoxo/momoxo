<?php

class XoopsThemeSetParser extends SaxParser
{
	var $tempArr = array();
	var $themeSetData = array();
	var $imagesData = array();
	var $templatesData = array();

	function XoopsThemeSetParser(&$input)
	{
		$this->SaxParser($input);
		$this->addTagHandler(new ThemeSetThemeNameHandler());
		$this->addTagHandler(new ThemeSetDateCreatedHandler());
		$this->addTagHandler(new ThemeSetAuthorHandler());
		$this->addTagHandler(new ThemeSetDescriptionHandler());
		$this->addTagHandler(new ThemeSetGeneratorHandler());
		$this->addTagHandler(new ThemeSetNameHandler());
		$this->addTagHandler(new ThemeSetEmailHandler());
		$this->addTagHandler(new ThemeSetLinkHandler());
		$this->addTagHandler(new ThemeSetTemplateHandler());
		$this->addTagHandler(new ThemeSetImageHandler());
		$this->addTagHandler(new ThemeSetModuleHandler());
		$this->addTagHandler(new ThemeSetFileTypeHandler());
		$this->addTagHandler(new ThemeSetTagHandler());
	}

	function setThemeSetData($name, &$value)
	{
		$this->themeSetData[$name] =& $value;
	}

	function &getThemeSetData($name=null)
	{
		if (isset($name)) {
			if (isset($this->themeSetData[$name])) {
				return $this->themeSetData[$name];
			}
			$ret = false;
			return $ret;
		}
		return $this->themeSetData;
	}

	function setImagesData(&$imagearr)
	{
		$this->imagesData[] =& $imagearr;
	}

	function &getImagesData()
	{
		return $this->imagesData;
	}

	function setTemplatesData(&$tplarr)
	{
		$this->templatesData[] =& $tplarr;
	}

	function &getTemplatesData()
	{
		return $this->templatesData;
	}

	function setTempArr($name, &$value, $delim='')
	{
		if (!isset($this->tempArr[$name])) {
			$this->tempArr[$name] =& $value;
		} else {
			$this->tempArr[$name] .= $delim.$value;
		}
	}

	function getTempArr()
	{
		return $this->tempArr;
	}

	function resetTempArr()
	{
		unset($this->tempArr);
		$this->tempArr = array();
	}
}
