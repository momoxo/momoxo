<?php

namespace Xoops\Delegate;

use Xoops\Delegate\DelegateInterface;

class Delegate implements DelegateInterface
{
    /**
     * @var array
     */
    private $callbacks = array();

    /**
     * Add callback function to this delegate
     *
     * Delegate MUST accepts multiple callbacks.
     *
     * @param callable $callback
     * @param int      $priority
     * @return void
     */
    public function add($callback, $priority = 0)
    {
        $this->callbacks[$priority][] = $callback;
        ksort($this->callbacks);
    }

    /**
     * Delete a callback function
     * @param callable $callback
     * @return void
     */
    public function remove($callback)
    {
        foreach ($this->callbacks as $priority => $callbacks) {
            foreach ($callbacks as $index => $thisCallback) {
                if ($thisCallback === $callback) {
                    unset($this->callbacks[$priority][$index]);
                }
            }
        }
    }

    /**
     * Remove all delegate functions
     * @return void
     */
    public function reset()
    {
        $this->callbacks = array();
    }

    /**
     * Call all callback functions
     *
     * Delegate MUST call each callback in ascending priority order.
     * Delegate MUST treat arguments with func_get_args().
     * Delegate MUST return the value which the final callback function returns.
     *
     * @return mixed
     */
    public function call()
    {
        $result = null;

        foreach ($this->callbacks as $callbacks) {
            foreach ($callbacks as $callback) {
                $result = call_user_func_array($callback, func_get_args());
            }
        }

        return $result;
    }
}
