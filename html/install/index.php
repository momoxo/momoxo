<?php

require __DIR__.'/bootstrap.php';

$controller = new \Momonga\Installer\Controller\DefaultController($installerConfig, $container);
$controller->run();
$controller->respond();
