<?php

namespace Xoops\Boot;

use XCore\Kernel\DelegateUtils;
use Xoops\Boot\BootCommandInterface;
use Xoops\Kernel\ControllerInterface;

class ProcessModule implements BootCommandInterface
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
        /** @var $root \XCore\Kernel\Root */
        $root = $this->controller->getRoot();
        /** @var $module \Xcore_AbstractModule */
        $module = $root->getContext()->getModule();

        if ($module) {
            $strategy = $this->controller->getStrategy();

            if ($module->isActive() === false) {
                DelegateUtils::call('Xcore.Event.Exception.ModuleNotActive', $module); // @todo Change delegate name
                $this->controller->forward(XOOPS_URL.'/');
            }

            if ($strategy->enableAccess() === false) {
                DelegateUtils::call('Xcore.Event.Exception.ModuleSecurity', $module); // @todo Change delegate name
                $this->controller->redirect(XOOPS_URL.'/user.php', 1, _NOPERM); // @todo Depends on const message catalog.
            }

            $strategy->setupModuleLanguage();
            $module->startup();

            $GLOBALS['xoopsModule'] = $module->getModule(); // @todo Avoid to use global variable
            $GLOBALS['xoopsModuleConfig'] = $module->getModuleConfig(); // @todo Avoid to use global variable
        }

        \Xcore_Utils::raiseUserControlEvent(); // @todo This may be not used
    }
}
