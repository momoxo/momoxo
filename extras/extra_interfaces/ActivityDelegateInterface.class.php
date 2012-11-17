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
 * Interface of acitivity delegate
**/
interface Xcore_iActivityDelegate
{
	/**
	 * addUserActivity	 Xcore_Activity.AddUserActivity
	 *
	 * @param Xcore_AbstractUserActivityObject &$activity
	 *
	 * @return	void
	 */ 
	public static function addUserActivity(/*** Xcore_AbstractUserActivityObject ***/ &$activity);

	/**
	 * deleteUserActivity	Xcore_Activity.DeleteUserActivity
	 *
	 * @param bool &$result
	 * @param CriteriaElement $cri ex)$cri=new CriteriaCompo();$cri->add(new Criteria('dirname',$dirname);$cri->add(new Criteria('dataname',$dataname);$cri->add(new Criteria('data_id',$data_id);
	 *
	 * @return	void
	 */ 
	public static function deleteUserActivity(/*** bool ***/ &$result, /*** CriteriaElement ***/ $cri);

	/**
	 * getUsersActivities	Xcore_Activity.GetUsersAcitivities
	 *
	 * @param Xcore_AbstractActivityObject[]	&$activityList
	 * @param int[]	$uids
	 * @param int	$limit
	 * @param int	$start
	 *
	 * @return	void
	 */ 
	public static function getUsersActivities(/*** Xcore_AbstractUserActivityObject[] ***/ &$activityList, /*** int[] ***/ $uids, /*** int ***/ $limit=20, /*** int ***/ $start=0);

	/**
	 * addGroupActivity	 Xcore_Activity.AddGroupActivity
	 *
	 * @param Xcore_AbstractUserActivityObject &$activity
	 *
	 * @return	void
	 */ 
	public static function addGroupActivity(/*** Xcore_AbstractGroupActivityObject ***/ &$activity);

	/**
	 * deleteGroupActivity	Xcore_Activity.deleteGroupActivity
	 *
	 * @param bool &$result
	 * @param CriteriaElement $cri ex)$cri=new CriteriaCompo();$cri->add(new Criteria('dirname',$dirname);$cri->add(new Criteria('dataname',$dataname);$cri->add(new Criteria('data_id',$data_id);
	 *
	 * @return	void
	 */ 
	public static function deleteGroupActivity(/*** bool ***/ &$result, /*** CriteriaElement ***/ $cri);

	/**
	 * getGroupsActivities	 Xcore_Activity.GetGroupsAcitivities
	 *
	 * @param Xcore_AbstractActivityObject[]	&$activityList
	 * @param int[]	$groupIds
	 * @param int	$limit
	 * @param int	$start
	 *
	 * @return	void
	 */ 
	public static function getGroupsActivities(/*** Xcore_AbstractGroupActivityObject[] ***/ &$activityList, /*** int[] ***/ $groupIds, /*** int ***/ $limit=20, /*** int ***/ $start=0);

}

?>
