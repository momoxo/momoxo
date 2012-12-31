<?php

namespace XCore\Kernel;

/**
 * This is an interface for request classes.
 */
abstract class AbstractRequest
{
    /**
     * Gets a value of the current request.
     * @param  string $key
     * @return mixed
     */
    public function getRequest($key)
    {
        return null;
    }
}
