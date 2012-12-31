<?php

namespace XCore\FormFile;

use XCore\Kernel\Root;

/**
 * WARNING:
 * This class is simple wrapper class for proccessing the file uploaded.
 * However, we have to examine the position of this class. We aims to simple file tree.
 * This class is only helper. We think that Cube system shouldn't offer misc helper.
 *
 * We put this class in root/class for the progress of this project. But, we will move
 * this to other directory in the future.
 */
class FormFile
{
    public $mName = null;

    public $mKey = null;

    public $mContentType = null;

    public $mFileName = null;
    public $mFileSize = 0;

    public $_mTmpFileName = null;

    public $mUploadFileFlag = false;

    public function __construct($name = null, $key = null)
    {
        $this->mName = $name;
        $this->mKey = $key;
    }

    /**
     * Fetch necessary information from $_FILES by $mName
     */
    public function fetch()
    {
        if ( $this->mName && isset($_FILES[$this->mName]) ) {
            if ($this->mKey != null) {
                $this->setFileName($_FILES[$this->mName]['name'][$this->mKey]);
                $this->setContentType($_FILES[$this->mName]['type'][$this->mKey]);
                $this->setFileSize($_FILES[$this->mName]['size'][$this->mKey]);
                $this->_mTmpFileName = $_FILES[$this->mName]['tmp_name'][$this->mKey];
            } else {
                $this->setFileName($_FILES[$this->mName]['name']);
                $this->setContentType($_FILES[$this->mName]['type']);
                $this->setFileSize($_FILES[$this->mName]['size']);
                $this->_mTmpFileName = $_FILES[$this->mName]['tmp_name'];
            }

            if ( $this->getFileSize() > 0 ) {
                $this->mUploadFileFlag = true;
            }
        }
    }

    public function hasUploadFile()
    {
        return $this->mUploadFileFlag;
    }

    /**
     * Return content type
     * @return string
     */
    public function getContentType()
    {
        return $this->mContentType;
    }

    public function getFileData()
    {
        // Now, implemeting.
    }

    /**
     * Return file name.
     * @return string
     */
    public function getFileName()
    {
        return $this->mFileName;
    }

    /**
     * Return file size.
     * @return int
     */
    public function getFileSize()
    {
        return $this->mFileSize;
    }

    /**
     * Return extension from file name.
     * @return string
     */
    public function getExtension()
    {
        $ret = null;
        $filename = $this->getFileName();
        if ( preg_match("/\.([a-z\.]+)$/i", $filename, $match) ) {
            $ret = $match[1];
        }

        return $ret;
    }

    /**
     * Set extension.
     * @param $ext
     * @return string
     */
    public function setExtension($ext)
    {
        $filename = $this->getFileName();
        if ( preg_match("/(.+)\.\w+$/", $filename, $match) ) {
                    $this->setFileName($match[1].".${ext}");
                }
    }

    /**
     * Set content type
     * @param $contenttype string
     */
    public function setContentType($contenttype)
    {
        $this->mContentType = $contenttype;
    }

    /**
     * Set file name
     * @param $filename string
     */
    public function setFileName($filename)
    {
        $this->mFileName = $filename;
    }

    /**
     * Set file size
     * @param $filesize int
     */
    public function setFileSize($filesize)
    {
        $this->mFileSize = $filesize;
    }

    /**
     * Set file body name. The extension is never changed.
     * @param $bodyname string
     */
    public function setBodyName($bodyname)
    {
        $this->setFileName($bodyname.".".$this->getExtension());
    }

    /**
     * Get file body name.
     * @return string
     */
    public function getBodyName()
    {
        if ( preg_match("/(.+)\.\w+$/", $this->getFileName(), $match) ) {
            return $match[1];
        }

        return null;
    }

    /**
     * Set random string to file body name. The extension is never changed.
     * @param $prefix string Prefix for random string.
     * @param $salt   string Salt for generating token.
     */
    public function setRandomToBodyName($prefix, $salt = '')
    {
        $filename = $prefix.$this->_getRandomString($salt).".".$this->getExtension();
        $this->setFileName($filename);
    }

    /**
     * Set random string to file body name. The extension is changed.
     * @param $prefix string Prefix for random string.
     * @param $salt   string Salt for generating token.
     */
    public function setRandomToFilename($prefix, $salt = '')
    {
        $filename = $prefix.$this->_getRandomString($salt);
        $this->setFileName($filename);
    }

    /**
    @brief Generate random string.
    @param $salt string Salt for generating token.
    @return string
     */
    public function _getRandomString($salt = '')
    {
        if ( empty($salt) ) {
            $root = Root::getSingleton();
            $salt = $root->getSiteConfig('Cube', 'Salt');
        }
        srand(microtime() * 1000000);

        return md5($salt.rand());
    }

    /**
     * Name this, and store it. If the name is specified as complete file name, store it as the same name.
     * If the name is specified as directory name, store it as the own name to the directory specified.
     *
     * @param  string $file Directory path or file path.
     * @return bool
     */
    public function saveAs($file)
    {

        $destFile = "";
        if ( preg_match("#\/$#", $file) ) {
            $destFile = $file.$this->getFileName();
        } elseif ( is_dir($file) ) {
            $destFile = $file."/".$this->getFileName();
        } else {
            $destFile = $file;
        }

        $ret = move_uploaded_file($this->_mTmpFileName, $destFile);

//		$prevMask = @umask(XCUBE_FORMFILE_PREVMASK);
//		@umask($prevMask);
        @chmod($destFile, XCUBE_FORMFILE_CHMOD);

        return $ret;
    }

    /**
     * Set random string to file body name, and store it. The extension is never changed.
     * @see saveAs()
     * @see setRandomToBodyName()
     * @param  string $dir    Directory for store.
     * @param  string $prefix Prefix for random string.
     * @param  string $salt   Salt for generating token.
     * @return bool
     */
    public function saveAsRandBody($dir, $prefix = '', $salt = '')
    {
        $this->setRandomToBodyName($prefix, $salt);

        return $this->saveAs($dir);
    }

    /**
     * Set random string to file name, and store it. The extension is never changed.
     * @see saveAs()
     * @see setRandomToFileName()
     * @param  string $dir    Directory for store.
     * @param  string $prefix Prefix for random string.
     * @param  string $salt   Salt for generating token.
     * @return bool
     */
    public function saveAsRand($dir, $prefix = '', $salt = '')
    {
        $this->setRandomToFileName($prefix, $salt);

        return $this->saveAs($dir);
    }
}
