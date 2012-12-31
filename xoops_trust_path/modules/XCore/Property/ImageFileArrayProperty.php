<?php

namespace XCore\Property;

use XCore\Property\FileArrayProperty;
use XCore\Property\ImageFileProperty;

/**
 * @see ImageFileProperty
 */
class ImageFileArrayProperty extends FileArrayProperty
{
    public function __construct($name)
    {
        parent::__construct("ImageFileProperty", $name);
    }
}
