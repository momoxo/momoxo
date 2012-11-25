<?php

class XcoreTplfileObject extends XoopsSimpleObject
{
	/**
	 * @access public
	 * @todo mSource
	 */
	var $Source = null;
	
	var $mOverride = null;
	
	function XcoreTplfileObject()
	{
		static $initVars;
		if (isset($initVars)) {
			$this->mVars = $initVars;
			return;
		}
		$this->initVar('tpl_id', XOBJ_DTYPE_INT, '', true);
		$this->initVar('tpl_refid', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('tpl_module', XOBJ_DTYPE_STRING, '', true, 25);
		$this->initVar('tpl_tplset', XOBJ_DTYPE_STRING, '', true, 50);
		$this->initVar('tpl_file', XOBJ_DTYPE_STRING, '', true, 50);
		$this->initVar('tpl_desc', XOBJ_DTYPE_STRING, '', true, 255);
		$this->initVar('tpl_lastmodified', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('tpl_lastimported', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('tpl_type', XOBJ_DTYPE_STRING, '', true, 20);
		$initVars=$this->mVars;
	}
	
	function loadSource()
	{
		if (!is_object($this->Source)) {
			$handler =& xoops_getmodulehandler('tplsource', 'xcoreRender');
			$this->Source =& $handler->get($this->get('tpl_id'));
			if (!is_object($this->Source)) {
				$this->Source =& $handler->create();
			}
		}
	}
	
	/**
	 * Create the clone with source for the template set that is specified by $tplsetName.
	 * 
	 * @param $tplsetName string
	 * @return object XcoreTplfileObject
	 */
	function &createClone($tplsetName)
	{
		$this->loadSource();
		
		$obj =new XcoreTplfileObject();

		$obj->set('tpl_refid', $this->get('tpl_refid'));
		$obj->set('tpl_module', $this->get('tpl_module'));

		$obj->set('tpl_tplset', $tplsetName);

		$obj->set('tpl_file', $this->get('tpl_file'));
		$obj->set('tpl_desc', $this->get('tpl_desc'));
		$obj->set('tpl_lastmodified', $this->get('tpl_lastmodified'));
		$obj->set('tpl_lastimported', $this->get('tpl_lastimported'));
		$obj->set('tpl_type', $this->get('tpl_type'));
		
		$handler =& xoops_getmodulehandler('tplsource', 'xcoreRender');
		$obj->Source =& $handler->create();
		
		$obj->Source->set('tpl_source', $this->Source->get('tpl_source'));
		
		return $obj;
	}
	
	/**
	 * Load override template file object by $tplset that is the name of template-set specified.
	 * And, set it to mOverride.
	 */
	function loadOverride($tplset)
	{
		if ($tplset == 'default' || $this->mOverride != null) {
			return;
		}
		
		$handler =& xoops_getmodulehandler('tplfile', 'xcoreRender');
		
		$criteria =new CriteriaCompo();
		$criteria->add(new Criteria('tpl_tplset', $tplset));
		$criteria->add(new Criteria('tpl_file', $this->get('tpl_file')));
		
		$objs =& $handler->getObjects($criteria);
		if (count($objs) > 0) {
			$this->mOverride =& $objs[0];
		}
	}
}
