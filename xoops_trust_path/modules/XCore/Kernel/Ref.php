<?php

namespace XCore\Kernel;

use XCore\Kernel\DelegateManager;
use XCore\Kernel\Delegate;

/**
 * This class is an expression of reference in delegation mechanism for PHP4.
 *
 * This class is adapt reference pointer for Delegate. Because Delegate is
 * virtual function pointers, it's impossible to hand variables as references to
 * Delegate::call(). In a such case, use this class as an adapter.
 *
 * ```
 * $object = new Object;
 * $delegate->call($object); // In PHP4, functions will receive the copied value of $object.
 *
 * $object = new Object;
 * $delegate->call(new Delegate($object)); // In PHP4, functions will receive the object.
 * ```
 */
final class Ref
{
    /**
     * @var mixed
     */
    private $_mObject = null;

    /**
     * Constructor.
     * @param mixed $obj
     */
    public function __construct(&$obj)
    {
        $this->_mObject =& $obj;
    }

    /**
     * Gets the value which this class is adapting.
     *
     * Only Delegate & DelegateManager should call this method.
     * @internal
     * @return mixed
     */
    public function &getObject()
    {
        return $this->_mObject;
    }
}
