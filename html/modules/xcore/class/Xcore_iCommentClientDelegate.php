<?php

/**
 * Interface of group client delegate
 * Modules which uses Xcore_Comment must implement this interface.
**/
interface Xcore_iCommentClientDelegate
{
	/**
	 * getClientList	Xcore_CommentClient.{dirname}.GetClientList
	 *
	 * @param mixed[]	&$list
	 *  string	$list[]['dirname']	client module's dirname
	 *  string	$list[]['dataname']	client module's dataname(tablename)
	 *  string	$list[]['access_controller']
	 * @param string	$cDirname	comment module's dirname
	 *
	 * @return	void
	 */ 
	public static function getClientList(/*** mixed[] ***/ &$list, /*** string ***/ $cDirname);
}
