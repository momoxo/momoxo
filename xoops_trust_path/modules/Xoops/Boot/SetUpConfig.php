<?php

namespace Xoops\Boot;

use Xoops\Boot\BootCommandInterface;
use Xoops\Kernel\ControllerInterface;

/**
 * Loads site configuration information, and sets them to the member property.
 */
class SetUpConfig implements BootCommandInterface
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

        $configHandler = xoops_gethandler('config');
        $config = $configHandler->getConfigsByCat(XOOPS_CONF);;
        $config['language'] = $root->getLanguageManager()->getLanguage();;

        $context->setXoopsConfig($config);

        $GLOBALS['xoopsConfig'] = $config; // @todo Never use global variable
        $GLOBALS['config_handler'] = $configHandler; // @todo Never use global variable
        $GLOBALS['module_handler'] = xoops_gethandler('module'); // @todo Never use global variable

        if ( count($context->getXoopsConfig()) == 0 ) {
            return;
        }

        $context->setThemeName($context->getXoopsConfig('theme_set'));

        $context->setAttribute('xcore_sitename', $context->getXoopsConfig('sitename'));
        $context->setAttribute('xcore_pagetitle', $context->getXoopsConfig('slogan'));
        $context->setAttribute('xcore_slogan', $context->getXoopsConfig('slogan'));
    }
}
