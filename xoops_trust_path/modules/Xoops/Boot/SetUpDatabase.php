<?php

namespace Xoops\Boot;

use Xoops\Boot\BootCommandInterface;
use Xoops\Kernel\ControllerInterface;
use XCore\Database\DatabaseFactory;

/**
 * Creates the instance of DataBase class, and sets it to Controller's member property.
 */
class SetUpDatabase implements BootCommandInterface
{
    /**
     * @var ControllerInterface
     */
    private $controller;

    /**
     * {@inherit}
     */
    public function setController(ControllerInterface $controller)
    {
        $this->controller = $controller;
    }

    /**
     * {@inherit}
     */
    public function execute()
    {
        if (defined('XOOPS_XMLRPC') === false) {
            define('XOOPS_DB_CHKREF', 1);
        } else {
            define('XOOPS_DB_CHKREF', 0);
        }

        if ($this->controller->getRoot()->getSiteConfig('Xcore', 'AllowDBProxy') == true) {
            if (xoops_getenv('REQUEST_METHOD') != 'POST' or xoops_refcheck(XOOPS_DB_CHKREF) === false) {
                define('XOOPS_DB_PROXY', 1);
            }
        } elseif (xoops_getenv('REQUEST_METHOD') != 'POST') {
            define('XOOPS_DB_PROXY', 1);
        }

        $db = DatabaseFactory::getDatabaseConnection();

        $this->controller->setDB($db);

        $GLOBALS['xoopsDB'] = $db; // @todo Never use global variable
    }
}

