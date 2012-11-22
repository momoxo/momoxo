<?php

/**
 * Interface of group client delegate
 * Modules which uses Xcore_Tag must implement this interface.
**/
interface Xcore_iTagClientDelegate
{
	/**
	 * getClientList	Xcore_TagClient.{dirname}.GetClientList
	 *
	 * @param mixed[]	&$list
	 *  @list[]['dirname']		client module dirname
	 *  @list[]['dataname']		client module dataname(tablename)
	 * @param string	$tDirname	Xcore_Tag module's dirname
	 *
	 * @return	void
	 */ 
	public static function getClientList(/*** mixed[] ***/ &$list, /*** string ***/ $tDirname);

	/**
	 * getClientData	Xcore_TagClient.{dirname}.GetClientData
	 *
	 * @param mixed		&$list
	 *	string	$list['dirname'][]	client module dirname
	 *	string	$list['dataname'][]	client module dataname(tablename)
	 *	mixed	$list['data'][] 	
	 *	string	$list['title'][]	client module title
	 *	string	$list['template_name'][]
	 * @param string	$dirname	client module dirname
	 * @param string	$dataname	client module dataname
	 * @param int[]		$idList		client module primary key list you want
	 *
	 * @return	void
	 */ 
	public static function getClientData(/*** mixed ***/ &$list, /*** string ***/ $dirname, /*** string ***/ $dataname, /*** int[] ***/ $idList);
}
