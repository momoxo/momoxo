<?php

namespace Xoops\Boot;

use XCore\Kernel\Ref;
use Xoops\Boot\BootCommandInterface;
use Xoops\Kernel\ControllerInterface;

/**
 * Sets up a principal object to the root object. In other words, restores
 * the principal object from session or other.
 */
class SetUpUser implements BootCommandInterface
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
        $context = $this->controller->getRoot()->getContext();
        $user = $context->getUser();

        $this->controller->getSetUpUserDelegate()->call(new Ref($user), new Ref($this->controller), new Ref($context));

        $context->setUser($user);

        $xoopsUser = $context->getXoopsUser();

        $GLOBALS['xoopsUser'] = $xoopsUser; // @todo Avoid to use global variable
        $GLOBALS['xoopsUserIsAdmin'] = is_object($xoopsUser) ? $xoopsUser->isAdmin(1) : false; // @todo Don't global
        $GLOBALS['xoopsMemberHandler'] = xoops_gethandler('member'); // @todo Avoid to use global variable
        $GLOBALS['member_handler'] = $GLOBALS['xoopsMemberHandler']; // @todo Avoid to use global variable
    }
}
