<?php

namespace XCore\Kernel;

class ServiceUtils
{
    public static function isXSD($typeName)
    {
        if ($typeName == 'string' || $typeName == 'int') {
            return true;
        }

        return false;
    }
}
