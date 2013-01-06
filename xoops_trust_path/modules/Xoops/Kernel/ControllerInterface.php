<?php

namespace Xoops\Kernel;

use Xoops\Kernel\ActionFilterInterface;
use Xoops\Logger\LoggerInterface;
use Xoops\Database\DatabaseInterface;
use Xoops\Delegate\DelegateInterface;

interface ControllerInterface
{
    /**
     * Return Root object
     * @return object
     * @todo add type hinting to comment above
     */
    public function getRoot();

    /**
     * Return ActionFilter objects
     * @return ActionFilterInterface[]
     */
    public function getActionFilters();

    /**
     * Set logger object
     * @param LoggerInterface $logger
     * @return void
     */
    public function setLogger(LoggerInterface $logger);

    /**
     * Return logger object
     * @return LoggerInterface
     */
    public function getLogger();

    /**
     * Set database
     * @param DatabaseInterface $db
     * @return void
     */
    public function setDB(DatabaseInterface $db);

    /**
     * Return database
     * @return DatabaseInterface
     */
    public function getDB();

    /**
     * Return GetLanguageName delegate
     * @return DelegateInterface
     */
    public function getGetLanguageNameDelegate();

    /**
     * Return CreateLanguageManager delegate
     * @return DelegateInterface
     */
    public function getCreateLanguageManagerDelegate();

    /**
     * @return DelegateInterface
     */
    public function getSetupTextFilterDelegate();

    /**
     * Set debugger
     * @param object $debugger
     * @return void
     * @todo add type hinting to comment above
     */
    public function setDebugger($debugger);

    /**
     * @return DelegateInterface
     */
    public function getSetUpDebuggerDelegate();

    /**
     * @return void
     */
    public function loadModulePreloads();

    /**
     * @return DelegateInterface
     */
    public function getSetUpUserDelegate();

    /**
     * Set up module context
     * @param string $dirname
     * @return void
     */
    public function setupModuleContext($dirname = null);

    /**
     * Forward controller
     * @param string $url
     * @return void
     */
    public function forward($url);

    /**
     * @return \Xcore_AbstractControllerStrategy
     */
    public function getStrategy();

    /**
     * Redirect to the specified URL with displaying message.
     * @param string $url
     * @param int    $time
     * @param string $message
     * @return void
     */
    public function redirect($url, $time = 1, $message = null);
}
