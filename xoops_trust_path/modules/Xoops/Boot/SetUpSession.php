<?php

namespace Xoops\Boot;

use XCore\Kernel\Session;
use Xoops\Boot\BootCommandInterface;
use Xoops\Kernel\ControllerInterface;

/**
 * Sets up handler for session, then starts session.
 */
class SetUpSession implements BootCommandInterface
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
        $root = $this->controller->getRoot();
        $context = $root->getContext();

        $useMySession  = $context->getXoopsConfig('use_mysession');
        $sessionName   = $context->getXoopsConfig('session_name');
        $sessionExpire = $context->getXoopsConfig('session_expire');

        $session = new Session();

        if ($useMySession) {
            $session->setParam($sessionName, $sessionExpire);
        }

        $session->start();

        $root->setSession($session);
    }
}
