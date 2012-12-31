<?php

namespace XCore\FormFile;

use XCore\FormFile\FormFile;

/**
 * The sub-class of FormFile to handle image upload file easily.
 */
class FormImageFile extends FormFile
{
    public function fetch()
    {
        parent::fetch();

        if ( $this->hasUploadFile() ) {
            if ( !$this->_checkFormat() ) {
                $this->mUploadFileFlag = false;
            }
        }
    }

    /**
     * Gets a width of the uploaded file.
     * @return int
     */
    public function getWidth()
    {
        list($width, $height, $type, $attr) = getimagesize($this->_mTmpFileName);

        return $width;
    }

    /**
     * Gets a height of the uploaded file.
     * @return int
     */
    public function getHeight()
    {
        list($width, $height, $type, $attr) = getimagesize($this->_mTmpFileName);

        return $height;
    }

    /**
     * Gets a value indicating whether a format of the uploaded file is allowed.
     * @access private
     * @return bool
     */
    public function _checkFormat()
    {
        if ( !$this->hasUploadFile() ) {
            return false;
        }

        list($width, $height, $type, $attr) = getimagesize($this->_mTmpFileName);

        switch ($type) {
            case IMAGETYPE_GIF:
                $this->setExtension("gif");
                break;

            case IMAGETYPE_JPEG:
                $this->setExtension("jpg");
                break;

            case IMAGETYPE_PNG:
                $this->setExtension("png");
                break;

            default:
                return false;
        }

        return true;
    }
}
