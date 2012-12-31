<?php

namespace XCore\Kernel;

use XCore\Kernel\DelegateUtils;
use XCore\Kernel\Delegate;

/**
 * Manages for delegates.
 *
 * This is the agent of un-registered delegate objects. Usually, connected
 * functions can't be added to un-registered delegates. When destination
 * delegates are un-registered yet, this manager is keeping those functions
 * and parameters until the destination delegate will be registered.
 *
 * In other words, this class realizes lazy delegate registering.
 */
class DelegateManager
{
    /**
     * Complex Array
     * @var array
     */
    protected $_mCallbacks = array();

    /**
     * Complex Array
     * @var array
     */
    protected $_mCallbackParameters = array();

    /**
     * @var array
     */
    protected $_mDelegates = array();

    /**
     * Constructor.
     */
    public function __construct()
    {
    }

    /**
     * Adds $delegate as Delegate to the list of this manager.
     *
     * If some functions that want to connect to $delegate, have been entrusted yet,
     * this object calls add() of $delegate with their parameters.
     *
     * Usually this member function isn't used as Cube's API by developers. In many
     * cases, Delegate::register() calls this.
     *
     * @param  string   $name     Registration name.
     * @param  Delegate $delegate Delegate object which will be registered.
     * @return bool
     */
    public function register($name, &$delegate)
    {
        $mDelegate =& $this->_mDelegates[$name];
        if (isset($mDelegate[$id=$delegate->getID()])) {
            return false;
        } else {
            $mDelegate[$id] =& $delegate;

            $mcb = &$this->_mCallbacks[$name];
            if (isset($mcb) && count($mcb) > 0) {
                foreach ($mcb as $key=>$func) {
                    list($a, $b) = $this->_mCallbackParameters[$name][$key];
                    $delegate->add($func, $a, $b);
                }
            }

            return true;
        }
    }

    /**
     * Connects functions to the delegate that have the specified name.
     *
     * If there aren't any delegates that have the specified name, this manager
     * entrust parameters to member properties. Then, when the delegate that
     * have the specified name will be registered, this manager will set these
     * parameters to the delegate.
     *
     * @param  string $name     Registration name.
     * @param         $callback
     * @param  null   $param3
     * @param  null   $param4
     * @return void
     * @see Delegate::add()
     */
    public function add($name, $callback, $param3 = null, $param4 = null)
    {
        if (isset($this->_mDelegates[$name])) {
            foreach ($this->_mDelegates[$name] as $func) {
                /** @var $func Delegate */
                $func->add($callback, $param3, $param4);
            }
        }
        $this->_mCallbacks[$name][] = $callback;
        $this->_mCallbackParameters[$name][] = array('0' => $param3, '1' => $param4);
    }

    /**
     * Disconnects a function from the delegate that have the specified name.
     * @param string $name Registration name
     * @param $delcallback*
     * @see Delegate::delete()
     */
    public function delete($name, $delcallback)
    {
        if (isset($this->_mDelegates[$name])) {
            foreach (array_keys($this->_mDelegates[$name]) as $key) {
                $this->_mDelegates[$name][$key]->delete($delcallback);
            }
        }
        if (isset($this->_mCallbacks[$name])) {
            foreach (array_keys($this->_mCallbacks[$name]) as $key) {
                $callback = $this->_mCallbacks[$name][$key];
                if (DelegateUtils::_compareCallback($callback, $delcallback)) {
                    unset($this->_mCallbacks[$name][$key]);
                    unset($this->_mCallbackParameters[$name][$key]);
                }
            }
        }
    }

    /**
     * Resets all functions off the delegate that have the specified name.
     * @param string $name Registration name which will be reset.
     * @see Delegate::reset()
     */
    public function reset($name)
    {
        if (isset($this->_mDelegates[$name])) {
            foreach (array_keys($this->_mDelegates[$name]) as $key) {
                $this->_mDelegates[$name][$key]->reset();
            }
        }
        if (isset($this->_mCallbacks[$name])) {
            unset($this->_mCallbacks[$name]);
            unset($this->_mCallbackParameters[$name]);
        }
    }

    /**
     * Gets a value indicating whether the specified delegate has callback functions.
     * @param  string $name Registration name.
     * @return bool
     */
    public function isEmpty($name)
    {
        if (isset($this->_mDelegates[$name])) {
            return $this->_mDelegates[$name]->isEmpty();
        }

        return isset($this->_mCallbacks[$name]) ? (count($this->_mCallbacks[$name]) == 0) : false;
    }

    /**
     * @return array
     */
    public function getDelegates()
    {
        return $this->_mDelegates;
    }
}
