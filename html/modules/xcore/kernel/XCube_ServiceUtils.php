<?php

class XCube_ServiceUtils
{
    function isXSD($typeName)
    {
        if ($typeName == 'string' || $typeName == 'int') {
            return true;
        }
        
        return false;
    }
}
