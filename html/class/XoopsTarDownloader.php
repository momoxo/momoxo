<?php

/**
 * Send tar files through a http socket
 *
 * @package		kernel
 * @subpackage	core
 *
 * @author		Kazumi Ono 	<onokazu@xoops.org>
 * @copyright	(c) 2000-2003 The Xoops Project - www.xoops.org
 */
class XoopsTarDownloader extends XoopsDownloader
{

	/**
	 * Constructor
	 * 
	 * @param string $ext       file extension
	 * @param string $mimyType  Mimetype
	 **/
	function XoopsTarDownloader($ext = '.tar.gz', $mimyType = 'application/x-gzip')
	{
		$this->archiver = new tar();
		$this->ext = trim($ext);
		$this->mimeType = trim($mimyType);
	}

	/**
	 * Add a file to the archive
	 * 
	 * @param   string  $filepath       Full path to the file
	 * @param   string  $newfilename    Filename (if you don't want to use the original)
	 **/
	function addFile($filepath, $newfilename=null)
	{
		$this->archiver->addFile($filepath);
		if (isset($newfilename)) {
			// dirty, but no other way
			for ($i = 0; $i < $this->archiver->numFiles; $i++) {
				if ($this->archiver->files[$i]['name'] == $filepath) {
					$this->archiver->files[$i]['name'] = trim($newfilename);
					break;
				}
			}
		}
	}

	/**
	 * Add a binary file to the archive
	 * 
	 * @param   string  $filepath       Full path to the file
	 * @param   string  $newfilename    Filename (if you don't want to use the original)
	 **/
	function addBinaryFile($filepath, $newfilename=null)
	{
		$this->archiver->addFile($filepath, true);
		if (isset($newfilename)) {
			// dirty, but no other way
			for ($i = 0; $i < $this->archiver->numFiles; $i++) {
				if ($this->archiver->files[$i]['name'] == $filepath) {
					$this->archiver->files[$i]['name'] = trim($newfilename);
					break;
				}
			}
		}
	}

	/**
	 * Add a dummy file to the archive
	 * 
	 * @param   string  $data       Data to write
	 * @param   string  $filename   Name for the file in the archive
	 * @param   integer $time
	 **/
	function addFileData(&$data, $filename, $time=0)
	{
		$dummyfile = XOOPS_CACHE_PATH.'/dummy_'.time().'.html';
		$fp = fopen($dummyfile, 'w');
		fwrite($fp, $data);
		fclose($fp);
		$this->archiver->addFile($dummyfile);
		unlink($dummyfile);

		// dirty, but no other way
		for ($i = 0; $i < $this->archiver->numFiles; $i++) {
			if ($this->archiver->files[$i]['name'] == $dummyfile) {
				$this->archiver->files[$i]['name'] = $filename;
				if ($time != 0) {
					$this->archiver->files[$i]['time'] = $time;
				}
				break;
			}
		}
	}

	/**
	 * Add a binary dummy file to the archive
	 * 
	 * @param   string  $data   Data to write
	 * @param   string  $filename   Name for the file in the archive
	 * @param   integer $time
	 **/
	function addBinaryFileData(&$data, $filename, $time=0)
	{
		$dummyfile = XOOPS_CACHE_PATH.'/dummy_'.time().'.html';
		$fp = fopen($dummyfile, 'wb');
		fwrite($fp, $data);
		fclose($fp);
		$this->archiver->addFile($dummyfile, true);
		unlink($dummyfile);

		// dirty, but no other way
		for ($i = 0; $i < $this->archiver->numFiles; $i++) {
			if ($this->archiver->files[$i]['name'] == $dummyfile) {
				$this->archiver->files[$i]['name'] = $filename;
				if ($time != 0) {
					$this->archiver->files[$i]['time'] = $time;
				}
				break;
			}
		}
	}

	/**
	 * Send the file to the client
	 * 
	 * @param   string  $name   Filename
	 * @param   boolean $gzip   Use GZ compression
	 **/
	function download($name, $gzip = true)
	{
		$file = $this->archiver->toTarOutput($name.$this->ext, $gzip);
		$this->_header($name.$this->ext);
		header('Content-Type: application/x-tar') ;
		header('Content-Length: '.floatval(@strlen($file))) ;
		echo $file;
	}
}
