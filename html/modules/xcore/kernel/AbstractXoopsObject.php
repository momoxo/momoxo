<?php

/**
 * Interface for all objects in the Xoops kernel.
 */
class AbstractXoopsObject
{
    function setNew()
    {
    }

    function unsetNew()
    {
    }

    /**
     * @return bool
     */
    function isNew()
    {
    }

    function initVar($key, $data_type, $default, $required, $size)
    {
    }

    /**
     * You should use this method to initilize object's properties.
     * This method may not trigger setDirty().
     * @param $values array
     */
    function assignVars($values)
    {
    }

    /**
     * You should use this method to change object's properties.
     * This method may trigger setDirty().
     */
    function set($key, $value)
    {
    }

    function get($key)
    {
    }

    /**
     * Return html string for template.
     * You can call get() method to get pure value.
     */
    function getShow($key)
    {
    }
}
