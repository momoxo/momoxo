<?php

/**
 * Sends non HTML files through a http socket
 * 
 * @package     kernel
 * @subpackage  core
 * 
 * @author	    Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */
class XoopsDownloader
{

	/**#@+
	 * file information
	 */
	var $mimetype;
	var $ext;
	var $archiver;
    /**#@-*/

	/**
	 * Constructor
	 */
	function XoopsDownloader()
	{
		//EMPTY
	}

	/**
	 * Send the HTTP header
     * 
     * @param	string  $filename
     * 
     * @access	private
	 */
	function _header($filename)
	{
		if (function_exists('mb_http_output')) {
			mb_http_output('pass');
		}
		header('Content-Type: '.$this->mimetype);
		if (preg_match("/MSIE ([0-9]\.[0-9]{1,2})/", $_SERVER['HTTP_USER_AGENT'])) {
			header('Content-Disposition: inline; filename="'.$filename.'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
		} else {
			header('Content-Disposition: attachment; filename="'.$filename.'"');
			header('Expires: 0');
			header('Pragma: no-cache');
		}
	}

	/**
	 * XoopsDownloader::addFile()
	 * 
	 * @param   string  $filepath
	 * @param   string   $newfilename
	 **/
	function addFile($filepath, $newfilename=null)
	{
		//EMPTY
	}

	/**
	 * XoopsDownloader::addBinaryFile()
	 * 
	 * @param   string  $filepath
	 * @param   string  $newfilename
	 **/
	function addBinaryFile($filepath, $newfilename=null)
	{
		//EMPTY
	}

	/**
	 * XoopsDownloader::addFileData()
	 * 
	 * @param   mixed     $data
	 * @param   string    $filename
	 * @param   integer   $time
	 **/
	function addFileData(&$data, $filename, $time=0)
	{
		//EMPTY
	}

	/**
	 * XoopsDownloader::addBinaryFileData()
	 * 
	 * @param   mixed   $data
	 * @param   string  $filename
	 * @param   integer $time
	 **/
	function addBinaryFileData(&$data, $filename, $time=0)
	{
		//EMPTY
	}

	/**
	 * XoopsDownloader::download()
	 * 
	 * @param   string  $name
	 * @param   boolean $gzip
	 **/
	function download($name, $gzip = true)
	{
		//EMPTY
	}
}
