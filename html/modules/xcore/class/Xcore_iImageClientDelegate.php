<?php

/**
 * Interface of image client delegate
 * Modules which uses Xcore_Image must implement this interface.
 * Xcore_Image module must be unique.
 * You can get its dirname by constant XCORE_IMAGE_DIRNAME
*/
interface Xcore_iImageClientDelegate
{
	/**
	 * getClientList	Xcore_Image.{dirname}.GetClientList
	 * Get client module's dirname and dataname(tablename)
	 *
	 * @param mixed[] &$list
	 *  $list[]['dirname']	client module dirname
	 *  $list[]['dataname']	client module dataname(tablename)
	 *
	 * @return	void
	 */ 
	public static function getClientList(/*** array ***/ &$list);
}
