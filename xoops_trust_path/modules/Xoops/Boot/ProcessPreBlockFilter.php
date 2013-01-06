<?php

namespace Xoops\Boot;

use Xoops\Boot\BootCommandInterface;
use Xoops\Kernel\ControllerInterface;

/**
 * Calls the preBlockFilter() member function of action filters which have been
 * loaded to the list of the controller.
 */
class ProcessPreBlockFilter implements BootCommandInterface
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
        $this->controller->loadModulePreloads();

        foreach ($this->controller->getActionFilters() as $actionFilter) {
            $actionFilter->preBlockFilter();
        }
    }
}
