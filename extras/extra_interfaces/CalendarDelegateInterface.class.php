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
 * Interface of calendar delegate
**/
interface Xcore_iCalendarDelegate
{
	/**
	 * getCalendarEvents	Xcore_Calendar.GetCalendarEvents
	 *
	 * @param Xcore_AbstractCalendarObject[] &$event
	 * @param int $start
	 * @param int $end
	 * @param int $uid
	 *
	 * @return	void
	 */	
	public static function getCalendarEvents(/*** mix[] ***/ &$event, /*** int ***/ $start, /*** int ***/ $end, /*** int ***/ $uid);

}

?>
