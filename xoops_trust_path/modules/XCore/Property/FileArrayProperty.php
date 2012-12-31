<?php

namespace XCore\Property;

use XCore\Property\FileProperty;
use XCore\Property\GenericArrayProperty;

/**
 * Represents the special property[] which handles uploaded file.
 * @see FileProperty
 */
class FileArrayProperty extends GenericArrayProperty
{
    public function __construct($name)
    {
        parent::__construct('XCore\Property\FileProperty', $name);
    }

    public function hasFetchControl()
    {
        return true;
    }

    public function fetch(&$form)
    {
        unset($this->mProperties);
        $this->mProperties = array();
        if (isset($_FILES[$this->mName]) && is_array($_FILES[$this->mName]['name'])) {
            foreach ($_FILES[$this->mName]['name'] as $_key => $_val) {
                $this->mProperties[$_key] = new $this->mPropertyClassName($this->mName);
                $this->mProperties[$_key]->mIndex = $_key;
                $this->mProperties[$_key]->fetch($form);
            }
        }
    }
}
