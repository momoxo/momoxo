<?php

use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;
use XCore\Property\IntArrayProperty;
use XCore\Property\StringProperty;

class Xcore_SearchResultsForm extends ActionForm
{
	var $mQueries = array();
	var $_mKeywordMin = 0;
	
	function Xcore_SearchResultsForm($keywordMin)
	{
		parent::__construct();
		$this->_mKeywordMin = intval($keywordMin);
	}
		
	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['mids'] =new IntArrayProperty('mids');
		$this->mFormProperties['andor'] =new StringProperty('andor');
		$this->mFormProperties['query'] =new StringProperty('query');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['andor'] =new FieldProperty($this);
		$this->mFieldProperties['andor']->setDependsByArray(array('mask'));
		$this->mFieldProperties['andor']->addMessage('mask', _MD_XCORE_ERROR_MASK, _MD_XCORE_LANG_ANDOR);
		$this->mFieldProperties['andor']->addVar('mask', '/^(AND|OR|exact)$/i');
	}
	
	function fetch()
	{
		parent::fetch();
		
		$t_queries = array();
		
		$myts =& MyTextSanitizer::getInstance();
		if ($this->get('andor') == 'exact' && strlen($this->get('query')) >= $this->_mKeywordMin) {
			$this->mQueries[] = $myts->addSlashes($this->get('query'));
		}
		else {
			$query = $this->get('query');
			if (defined('XOOPS_USE_MULTIBYTES')) {
				$query = xoops_trim($query);
			}

			$separator = '/[\s,]+/';
			if (defined('_MD_XCORE_FORMAT_SEARCH_SEPARATOR')) {
				$separator = _MD_XCORE_FORMAT_SEARCH_SEPARATOR;
			}
		
			$tmpArr = preg_split($separator, $query);
			foreach ($tmpArr as $tmp) {
				if (strlen($tmp) >= $this->_mKeywordMin) {
					$this->mQueries[] = $myts->addSlashes($tmp);
				}
			}
		}
		
		$this->set('query', implode(" ", $this->mQueries));
	}
	
	function fetchAndor()
	{
		if ($this->get('andor') == "") {
			$this->set('andor', 'AND');
		}
	}
	
	function validate()
	{
		parent::validate();
		
		if (!count($this->mQueries)) {
			$this->addErrorMessage(_MD_XCORE_ERROR_SEARCH_QUERY_REQUIRED);
		}
	}
	
	function update(&$params)
	{
		$mids = $this->get('mids');
		if (count($mids) > 0) {
			$params['mids'] = $mids;
		}
		
		$params['queries'] = $this->mQueries;
		$params['andor'] = $this->get('andor');
		$params['maxhit'] = XCORE_SEARCH_RESULT_MAXHIT;
	}
}

