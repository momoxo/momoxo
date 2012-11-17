<?php
/**
 * @file
 * @package xcore
 * @version $Id$
**/

if(!defined('XOOPS_ROOT_PATH'))
{
	exit();
}

/**
 * Abstract Activity Class
**/
abstract class Xcore_AbstractActivityObject extends XoopsSimpleObject
{
	public function __construct()
	{
		$this->initVar('activity_id', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('dirname', XOBJ_DTYPE_STRING, '', false, 32);
		$this->initVar('dataname', XOBJ_DTYPE_STRING, '', false, 32);
		$this->initVar('data_id', XOBJ_DTYPE_INT, '0', false);
		$this->initVar('uid', XOBJ_DTYPE_INT, '0', false);
		//cat_id is field in Xcore_AbstractCategoryObject
		$this->initVar('cat_id', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('title', XOBJ_DTYPE_STRING, '', false, 255);
		$this->initVar('description', XOBJ_DTYPE_TEXT, '', false);
		$this->initVar('pubdate', XOBJ_DTYPE_INT, time(), false);
		$this->initVar('category', XOBJ_DTYPE_STRING, '', false, 255);
		$this->initVar('author', XOBJ_DTYPE_STRING, '', false, 128);
		$this->initVar('link', XOBJ_DTYPE_TEXT, '', false);
		$this->initVar('latitude', XOBJ_DTYPE_FLOAT, '0.0', false);
		$this->initVar('longitude', XOBJ_DTYPE_FLOAT, '0.0', false);
		$this->initVar('posttime', XOBJ_DTYPE_INT, time(), false);
	}
}

/**
 * Abstract Group Activity Class
**/
abstract class Xcore_AbstractGroupActivityObject extends Xcore_AbstractActivityObject
{
	public function __construct()
	{
		parent::__construct();
		$this->initVar('group_id', XOBJ_DTYPE_INT, '0', false);
	}
}

/**
 * Abstract User Activity Class
**/
abstract class Xcore_AbstractUserActivityObject extends Xcore_AbstractActivityObject
{
	public function __construct()
	{
		parent::__construct();
		$this->initVar('guest_access', XOBJ_DTYPE_INT, '0', false);
	}
}

/**
 * Abstract Calendar Activity Class
**/
abstract class Xcore_AbstractCalendarObject extends Xcore_AbstractActivityObject{
	public function __construct()
	{
		parent::__construct();
		$this->initVar('location', XOBJ_DTYPE_STRING, '', false, 255);
		$this->initVar('starttime', XOBJ_DTYPE_STRING, '0', false);
		$this->initVar('endtime', XOBJ_DTYPE_STRING, '0', false);
	}
}

abstract class Xcore_AbstractActivityHandler extends XoopsObjectGenericHandler
{
	abstract public function getActivities(/*** int ***/ $data_id, /*** int ***/ $limit=20, /*** int ***/ $start=0);
	abstract public function getMyActivities(/*** int ***/ $uid, /*** int ***/ $limit=20, /*** int ***/ $start=0);

}

?>
