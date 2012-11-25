<?php

/**
 * Interface of group client delegate
 * Modules which uses Xcore_Activity must implement this interface.
 * Xcore_Activity module must be unique.
 * You can get its dirname by constant XCORE_ACTIVITY_DIRNAME
**/
interface Xcore_iActivityClientDelegate
{
	/**
	 * getClientList	Xcore_ActivityClient.GetClientList
	 *
	 * @param mixed[]	&$list
	 *  @list[]['dirname']	client module's dirname
	 *  @list[]['dataname']	client module's dataname(tablename)
	 *  @list[]['access_controller']	access controller's module dirname
	 *
	 * @return	void
	 */ 
	public static function getClientList(/*** mixed[] ***/ &$list);

	/**
	 * getClientData	Xcore_ActivityClient.{dirname}.GetClientData
	 *
	 * @param mixed		&$list
	 *  string	$list['dirname']	client module's dirname
	 *  string	$list['dataname']	client module's dataname(tablename)
	 *  int		$list['data_id']	client module's primary key
	 *  mixed	$list['data']
	 *  string  $list['title']		client module's title
	 *  string	$list['template_name']
	 * @param string	$dirname
	 * @param string	$dataname
	 * @param int		$dataId
	 *
	 * @return	void
	 */ 
	public static function getClientData(/*** mixed ***/ &$list, /*** string ***/ $dirname, /*** string ***/ $dataname, /*** int ***/ $dataId);

	/**
	 * getClientFeed	Xcore_ActivityClient.{dirname}.GetClientFeed
	 *
	 * @param mixed		&$list
	 *  string[]	$list['title']	entry's title
	 *  string[]	$list['link']	link to entry
	 *  string[]	$list['id']		entry's id(=permalink to entry)
	 *  int[]		$list['updated']	unixtime
	 *  int[]		$list['published']	unixtime
	 *  string[]	$list['author']
	 *  string[]	$list['content']
	 * @param string	$dirname	client module's dirname
	 * @param string	$dataname	client module's dataname(tablename)
	 * @param int		$dataId		client module's primary key
	 *
	 * @return	void
	 */ 
	public static function getClientFeed(/*** mixed ***/ &$list, /*** string ***/ $dirname, /*** string ***/ $dataname, /*** int ***/ $dataId);
}
