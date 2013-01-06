<?php

namespace Xoops\Delegate;

interface DelegateInterface
{
    /**
     * Add callback function to this delegate
     *
     * Delegate MUST accepts multiple callbacks.
     *
     * @param callable $callback
     * @param int $priority
     * @return void
     */
    public function add($callback, $priority = 0);

    /**
     * Remove a callback function
     * @param callable $callback
     * @return void
     */
    public function remove($callback);

    /**
     * Remove all delegate functions
     * @return void
     */
    public function reset();

    /**
     * Call all callback functions
     *
     * Delegate MUST call each callback in ascending priority order.
     * Delegate MUST treat arguments with func_get_args().
     *
     * @return mixed
     */
    public function call();
}
