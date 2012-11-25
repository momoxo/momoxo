<?php

class XoopsZipDownloader extends XoopsDownloader
{
    function XoopsZipDownloader($ext = '.zip', $mimyType = 'application/x-zip')
    {
        $this->archiver = new zipfile();
        $this->ext      = trim($ext);
        $this->mimeType = trim($mimyType);
    }

    function addFile($filepath, $newfilename=null)
    {
        // Read in the file's contents
        $fp = fopen($filepath, "r");
        $data = fread($fp, filesize($filepath));
        fclose($fp);
        $filename = (isset($newfilename) && trim($newfilename) != '') ? trim($newfilename) : $filepath;
        $filepath = is_file($filename) ? $filename : $filepath;
        $this->archiver->addFile($data, $filename, filemtime($filepath));
    }

    function addBinaryFile($filepath, $newfilename=null)
    {
        // Read in the file's contents
        $fp = fopen($filepath, "rb");
        $data = fread($fp, filesize($filepath));
        fclose($fp);
        $filename = (isset($newfilename) && trim($newfilename) != '') ? trim($newfilename) : $filepath;
        $filepath = is_file($filename) ? $filename : $filepath;
        $this->archiver->addFile($data, $filename, filemtime($filepath));
    }

    function addFileData(&$data, $filename, $time=0)
    {
        $this->archiver->addFile($data, $filename, $time);
    }

    function addBinaryFileData(&$data, $filename, $time=0)
    {
        $this->addFileData($data, $filename, $time);
    }

    function download($name, $gzip = true)
    {
		$file = $this->archiver->file();
		$this->_header($name.$this->ext);
		header('Content-Type: application/zip') ;
		header('Content-Length: '.floatval(@strlen($file))) ;
		echo $file;
    }
}
