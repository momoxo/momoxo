<?php

use Momonga\Installer\TrustPathFinder;
use Momonga\Installer\InstallerConfig;

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
use Momonga\Installer\Service\RequirementTestService;
use Momonga\Installer\Requirement\PHPExtensionRequirement;
use Momonga\Installer\Requirement\FileWritableRequirement;
use Momonga\Installer\Service\ConfigCreationService;
use Momonga\Installer\ConfigFormatter\ConstantFormatter;
use Momonga\Installer\Requirement\DatabaseConnectableRequirement;
use Momonga\Installer\Database\ConnectionFactory;
use Momonga\Installer\Service\DatabaseConnectionTestService;
use Momonga\Installer\Service\DatabaseConstructionService;

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
		->setSqlUtility(new \Momonga\Installer\Database\SqlUtility())
		->setConnectionFactory(new \Momonga\Installer\Database\ConnectionFactory())
		->setPasswordEncryptor(new $encryptorClass);
	return $service;
};