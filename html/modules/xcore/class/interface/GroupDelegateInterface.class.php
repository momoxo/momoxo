<?php

/**
 * Interface of group delegate
**/
interface Xcore_iGroupDelegate
{
	/**
	 * getTitle 	Xcore_Group.{dirname}.GetTitle
	 * get the group title by group id.
	 *
	 * @param string 	&$title
	 * @param string	$gDirname	Group Module Dirname
	 * @param int 		$groupId
	 *
	 * @return	void
	 */ 
	public static function getTitle(/*** string ***/ &$title, /*** string ***/ $gDirname, /*** int ***/ $groupId);

	/**
	 * getTitleList 	Xcore_Group.{dirname}.GetTitleList
	 * get group titles.
	 *
	 * @param string[]	&$titleList
	 * @param string	$gDirname	Group Module Dirname
	 *
	 * @return	void
	 */ 
	public static function getTitleList(/*** string[] ***/ &$titleList, /*** string ***/ $gDirname);

	/**
	 * hasPermission	Xcore_Group.{dirname}.HasPermission
	 *
	 * @param bool	 &$check
	 * @param string $gDirname
	 * @param int	 $groupId
	 * @param string $dirname
	 * @param string $dataname
	 * @param string $action
	 *
	 * @return	void
	 */ 
	public static function hasPermission(/*** bool ***/ &$check, /*** string ***/ $gDirname, /*** int ***/ $groupId, /*** string ***/ $dirname, /*** string ***/ $dataname, /*** string ***/ $action);

	/**
	 * getGroupIdList Xcore_Group.{dirname}.GetMyGroupIdList
	 *
	 * @param int[] 	&$list
	 * @param string	$gDirname	Group Module Dirname
	 * @param Enum	$rank	Lenum_GroupRank
	 * @param int		$limit
	 * @param int		$start
	 *
	 * @return	void
	 */ 
	public static function getGroupIdList(/*** int[] ***/ &$list, /*** string ***/ $gDirname, /*** Enum ***/ $rank, /*** int ***/ $limit=null, /*** int ***/ $start=null);

	/**
	 * getGroupList Xcore_Group.{dirname}.GetMyGroupList
	 *
	 * @param Xcore_AbstractGroupObject[] &$list
	 * @param string	$gDirname	Group Module Dirname
	 * @param Enum		$rank	Lenum_GroupRank
	 * @param int		$limit
	 * @param int		$start
	 *
	 * @return	void
	 */ 
	public static function getGroupList(/*** mixed[] ***/ &$list, /*** string ***/ $gDirname, /*** Enum ***/ $rank, /*** int ***/ $limit=null, /*** int ***/ $start=null);

	/**
	 * getGroupIdListByAction Xcore_Group.{dirname}.GetGroupIdListByAction
	 *
	 * @param int[] 	&$list
	 * @param string	$gDirname	Group Module Dirname
	 * @param string	$dirname
	 * @param string	$dataname
	 * @param string	$action
	 * @param int		$limit
	 * @param int		$start
	 *
	 * @return	void
	 */ 
	public static function getGroupIdListByAction(/*** int[] ***/ &$list, /*** string ***/ $gDirname, /*** string ***/ $dirname, /*** string ***/ $dataname, /*** string ***/ $action, /*** int ***/ $limit=null, /*** int ***/ $start=null);

	/**
	 * getGroupListByAction Xcore_Group.{dirname}.GetGroupListByAction
	 *
	 * @param Xcore_AbstractGroupObject[] &$list
	 * @param string	$gDirname	Group Module Dirname
	 * @param string	$dirname
	 * @param string 	$dataname
	 * @param string 	$action
	 * @param int		$limit
	 * @param int		$start
	 *
	 * @return	void
	 */ 
	public static function getGroupListByAction(/*** mixed[] ***/ &$list, /*** string ***/ $gDirname, /*** string ***/ $dirname, /*** string ***/ $dataname, /*** string ***/ $action, /*** int ***/ $limit=null, /*** int ***/ $start=null);

	/**
	 * getMemberList	  Xcore_Group.{dirname}.GetMemberList
	 * get member list in the given group
	 *
	 * @param mixed $list
	 *	$list['uid']
	 *	$list['rank']
	 * @param string	$gDirname	Group Module Dirname
	 * @param int		$groupId
	 * @param Enum		$rank	Lenum_GroupRank
	 *
	 * @return	void
	 */ 
	public static function getMemberList(/*** int[] ***/ &$list, /*** string ***/ $gDirname, /*** int ***/ $groupId, /*** Enum ***/ $rank);

	/**
	 * isMember 	 Xcore_Group.{dirname}.IsMember
	 * check the user's belonging and rank in the given group
	 *
	 * @param string	$gDirname	Group Module Dirname
	 * @param bool	&$check
	 * @param int	$groupId
	 * @param int	$uid
	 * @param Enum	$rank	Lenum_GroupRank
	 *
	 * @return	void
	 */ 
	public static function isMember(/*** bool ***/ &$check, /*** string ***/ $gDirname, /*** int ***/ $groupId, /*** int ***/ $uid, /*** Enum ***/ $rank=Lenum_GroupRank::REGULAR);
}

?>
