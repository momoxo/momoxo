<?php

namespace Xoops\Error;

interface ErrorHandlerInterface
{
    /**
     * Handle an error
     * @param int $severity
     * @param string $message
     * @param string $filename
     * @param int $line
     * @return void
     */
    public function handle($severity, $message, $filename, $line);
}
