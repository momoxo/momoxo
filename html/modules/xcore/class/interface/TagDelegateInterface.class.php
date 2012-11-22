<?php

/**
 * Interface of tag delegate
**/
interface Xcore_iTagDelegate
{
	/**
	 * setTags	Xcore_Tag.{dirname}.SetTags
	 *
	 * @param bool		$result
	 * @param string	$tDirname	Xcore_Tag module's dirname
	 * @param string	$dirname	client module dirname
	 * @param string	$dataname	client module dataname(tablename)
	 * @param int		$dataId		client module primary key
	 * @param int		$posttime
	 * @param string[]	$tagArr		tags for this data
	 */	
	public static function setTags($result, $tDirname, $dirname, $dataname, $dataId, $posttime, $tagArr);

	/**
	 * getTags	Xcore_Tag.{dirname}.GetTags
	 * get tags from dirname/dataname/data_id
	 *
	 * @param string[] $tagArr
	 * @param string	$tDirname	Xcore_Tag module's dirname
	 * @param string	$dirname	client module dirname
	 * @param string	$dataname	client module dataname(tablename)
	 * @param int		$dataId		client module primary key
	 */	
	public static function getTags(&$tagArr, $tDirname, $dirname, $dataname, $dataId);

	/**
	 * getTagCloudSrc	Xcore_Tag.{dirname}.GetTagCloudSrc
	 *
	 * @param mixed		$cloud
	 *	 $cloud[$tag] = $count
	 * @param string	$tDirname	Xcore_Tag module's dirname
	 * @param string	$dirname	client module dirname
	 * @param string	$dataname	client module dataname
	 * @param int[]		$uidList	whose tags you want
	 */	
	public static function getTagCloudSrc(&$cloud, $tDirname, $dirname=null, $dataname=null, $uidList=array());

	/**
	 * getDataIdListByTags	Xcore_Tag.{dirname}.GetDataIdListByTags
	 *
	 * @param int[]		$list
	 * @param string	$tDirname	Xcore_Tag module's dirname
	 * @param string[]	$tagArr		tag list
	 * @param string	$dirname	client module dirname
	 * @param string	$dataname	client module dataname
	 */	
	public static function getDataIdListByTags(&$list, $tDirname, $tagArr, $dirname, $dataname);

}

