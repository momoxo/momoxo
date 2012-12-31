<?php

use XCore\Repository\ObjectGenericRepository;
use XCore\Database\CriteriaCompo;
use XCore\Entity\SimpleObject;
use XCore\Database\Criteria;

class XcoreTplfileHandler extends ObjectGenericRepository
{
	var $mTable = "tplfile";
	var $mPrimary = "tpl_id";
	var $mClass = "XcoreTplfileObject";
	
	function insert(&$obj, $force = false)
	{
		if (!parent::insert($obj, $force)) {
			return false;
		}
		
		$obj->loadSource();
		
		if (!is_object($obj->Source)) {
			return true;
		}
		else {
			$handler =& xoops_getmodulehandler('tplsource', 'xcore');

			if ($obj->Source->isNew()) {
				$obj->Source->set('tpl_id', $obj->get('tpl_id'));
			}

			return $handler->insert($obj->Source, $force);
		}
	}
	
	/**
	 * This method load objects of two template sets by $criteria. Then, build 
	 * the return value from the objects of 'default', and set the objects of
	 * $tplset to object->mOverride.
	 */
	function &getObjectsWithOverride($criteria, $tplset)
	{
		$objs =& $this->getObjects($criteria);
		
		$ret = array();
		$dobjs = array();
		foreach ($objs as $obj) {
			$set = $obj->get('tpl_tplset');
			if ($set == 'default') $ret[] = $obj;
			if ($set == $tplset) $dobjs[$obj->get('tpl_file')] = $obj;
		}
		
		foreach ($ret as $obj) {
			$obj->mOverride = $dobjs[$obj->get('tpl_file')];
		}
		
		return $ret;
	}
	
	function delete(&$obj, $force = false)
	{
		$obj->loadSource();
		
		if (is_object($obj->Source)) {
			$handler =& xoops_getmodulehandler('tplsource', 'xcore');
			if (!$handler->delete($obj->Source, $force)) {
				return false;
			}
		}

		return parent::delete($obj, $force);
	}
	
	/**
	 * This is a kind of getObjects(). Return objects that were modified recently.
	 * 
	 * @param $limit int
	 * @return array array of the object
	 */
	function &getRecentModifyFile($limit = 10)
	{
		$criteria = new Criteria('tpl_id', 0, '>');

		$criteria->setLimit($limit);

		$criteria->setSort('tpl_lastmodified');
		$criteria->setOrder('DESC');
		
		$objs =& $this->getObjects($criteria);
		
		return $objs;
	}
	
	/**
	 * This is a kind of getObjects(). Call getObjects() by 5 parameters and return
	 * the result. Parameters are guaranteed Type Safe because these are used by
	 * getObjects() for SimpleObject.
	 * 
	 * @param $tplsetName string
	 * @param $type       string
	 * @param $refId      int
	 * @param $module     string
	 * @param $file       string
	 * @return array      array of the object.
	 */
	function &find($tplsetName, $type = null, $refId = null, $module = null, $file = null) {
		$criteria =new CriteriaCompo();
		$criteria->add(new Criteria('tpl_tplset', $tplsetName));
		if ($type != null) {
			$criteria->add(new Criteria('tpl_type', $type));
		}
		if ($refId != null) {
			$criteria->add(new Criteria('tpl_refid', $refId));
		}
		if ($module != null) {
			$criteria->add(new Criteria('tpl_module', $module));
		}
		if ($file != null) {
			$criteria->add(new Criteria('tpl_file', $file));
		}
		
		$objs =& $this->getObjects($criteria);
		return $objs;
	}
}
