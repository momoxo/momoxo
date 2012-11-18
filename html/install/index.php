<?php

$xoops_root_path = dirname(dirname(__FILE__));


$config_path = $xoops_root_path . '/config/config.php';
if (file_exists($config_path) === true) {
  require_once($config_path);
  header('Location: ' . XOOPS_URL);
  exit;
}

$xoops_trust_paths = array(
  $xoops_root_path . '/xoops_trust_path',
  dirname($xoops_root_path) . '/xoops_trust_path',
);
foreach ($xoops_trust_paths as $xoops_trust_path) {
  if (is_dir($xoops_trust_path) === true) {
    break;
  }
  $xoops_trust_path = null;
}

if ($xoops_trust_path === null) {
  die('xoops_trust_pathが見つかりません.');
}

$op = 'step1';
if (isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] !== '') {
  $op = ltrim($_SERVER['PATH_INFO'], '/');
}

define('INSTALLER_DIR', $xoops_trust_path . '/installer');
define('INSTALLER_URL', $_SERVER['SCRIPT_NAME']);

$response = array(
  'base' => dirname(INSTALLER_URL),
);
require_once INSTALLER_DIR . '/class/' . $op . '.php';
$response = array_merge($response, process($xoops_root_path, $xoops_trust_path, $config_path));

require_once 'phar://'. INSTALLER_DIR . '/lib/twig.phar/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem(INSTALLER_DIR.'/templates');
$twig = new Twig_Environment($loader, array('debug' => true));
$twig->addGlobal('layout', $twig->loadTemplate('layout.twig'));

echo $twig->render($op . '.twig', $response);
