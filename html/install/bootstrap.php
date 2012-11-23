<?php

use Momoxo\Installer\TrustPathFinder;
use Momoxo\Installer\InstallerConfig;

// Load classes
spl_autoload_register(function($c) { @include_once strtr($c, '\\_', '//').'.php'; });
set_include_path(get_include_path().PATH_SEPARATOR.__DIR__.'/src');
require_once __DIR__.'/vendor/twig.phar';
require_once __DIR__.'/vendor/Pimple.php';


// Initialize conifg
$installerConfig = new InstallerConfig(__DIR__.'/config/config.json', array(
	'xoops_root_path' => dirname(__DIR__),
	'installer_dir'    => __DIR__,
	'installer_url'    => $_SERVER['SCRIPT_NAME'],
	'installer_base_url'    => dirname($_SERVER['SCRIPT_NAME']),
));

// Check config.php
if (file_exists($installerConfig->get('config_filename')) === true) {
	require_once $installerConfig->get('config_filename');
	header('Location: ' . XOOPS_URL);
	exit;
}

// Find xoops_trust_path
$finder = new TrustPathFinder();
$xoopsTrustPath = $finder->find($installerConfig->get('xoops_root_path'));

if ($xoopsTrustPath === false) {
	die('xoops_trust_pathが見つかりません.');
}

$installerConfig->set('xoops_trust_path', $xoopsTrustPath);

// Dependency injection
use Momoxo\Installer\Service\RequirementTestService;
use Momoxo\Installer\Requirement\PHPExtensionRequirement;
use Momoxo\Installer\Requirement\FileWritableRequirement;
use Momoxo\Installer\Service\ConfigCreationService;
use Momoxo\Installer\ConfigFormatter\ConstantFormatter;
use Momoxo\Installer\Requirement\DatabaseConnectableRequirement;
use Momoxo\Installer\Database\ConnectionFactory;
use Momoxo\Installer\Service\DatabaseConnectionTestService;
use Momoxo\Installer\Service\DatabaseConstructionService;

$container = new Pimple();

$container['service.requirement_test'] = function($container) {
	$requirementTestService = new RequirementTestService();
	$requirementTestService
		->setPHPExtensionRequirement(new PHPExtensionRequirement())
		->setFileWritableRequirement(new FileWritableRequirement());
	return $requirementTestService;
};

$container['service.config_creation'] = function($container) use ($installerConfig) {
	$configCreationService = new ConfigCreationService();
	$configCreationService
		->setConfigDirectory($installerConfig->get('config_dir'))
		->setFormatter(new ConstantFormatter());
	return $configCreationService;
};

$container['service.database_connection_test'] = function($container) {
	$requirement = new DatabaseConnectableRequirement();
	$requirement->setConnectionFactory(new ConnectionFactory());
	$service = new DatabaseConnectionTestService();
	$service->setDatabaseConnectableRequirement($requirement);
	return $service;
};

$container['service.database_construction'] = function($container) use ($installerConfig) {
	$encryptorClass = $installerConfig->get('password_encryptor');
	$service = new DatabaseConstructionService();
	$service
		->setSqlUtility(new \Momoxo\Installer\Database\SqlUtility())
		->setConnectionFactory(new \Momoxo\Installer\Database\ConnectionFactory())
		->setPasswordEncryptor(new $encryptorClass);
	return $service;
};