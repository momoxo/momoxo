<?php

namespace Xoops\Boot;

use XCore\Kernel\Ref;
use Xoops\Boot\BootCommandInterface;
use Xoops\Kernel\ControllerInterface;

/**
 * Creates the instance of Text Filter class, and sets it to member property.
 */
class SetUpTextFilter implements BootCommandInterface
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
        $textFilter = null;
        $this->controller->getSetupTextFilterDelegate()->call(new Ref($textFilter));
        $this->controller->getRoot()->setTextFilter($textFilter);
    }
}
