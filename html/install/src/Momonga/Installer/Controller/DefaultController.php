<?php

namespace Momonga\Installer\Controller;

use Pimple;
use Twig_Loader_Filesystem;
use Twig_Environment;
use Exception;
use Momonga\Installer\InstallerConfig;
use Momonga\Installer\DataTransferObject\RequirementTestDTO;
use Momonga\Installer\ValueObject\Site;
use Momonga\Installer\Form\ConfigurationForm;
use Momonga\Installer\Factory\SiteFactory;

class DefaultController
{
	/**
	 * @var InstallerConfig
	 */
	private $config;

	/**
	 * @var Pimple
	 */
	private $container;

	/**
	 * @var array
	 */
	private $response = array();

	/**
	 * @var string
	 */
	private $template = '';

	public function __construct(InstallerConfig $config, Pimple $container)
	{
		$this->config = $config;
		$this->container = $container;
		$this->response = array(
			'base' => $this->config->get('installer_base_url'),
		);
	}

	/**
	 * @param string $name
	 * @return object
	 */
	public function get($name)
	{
		return $this->container[$name];
	}

	public function run()
	{
		$response = $this->inputAction();
		$this->response = array_merge($this->response, $response);
	}

	public function inputAction()
	{
		// @todo SSL対応
		$xoopsUrl = sprintf('http://%s/%s', $_SERVER['SERVER_NAME'], str_replace('/install/index.php', '', $_SERVER['SCRIPT_NAME']));
		$xoopsUrl = rtrim($xoopsUrl, '/');

		$requirementTestResult = $this->_testRequirement();

		$form = new ConfigurationForm();
		$form->setURL($this->_getXoopsUrl());

		if ( $form->isMethod('POST') ) {
			$form->fetch($_POST);
			if ( $form->isValid() == false ) {
				goto input_page;
			}

			$siteFactory = new SiteFactory();
			$site = $siteFactory->createByConfigurationForm($form, $this->config);

			if ( $this->_testDatabaseConnection($site) === false ) {
				$form->addError("データベースに接続できません。設定を確認してください。");
				goto input_page;
			}

			try {
				$this->_createConfig($site);
				$this->_createDatabase($site);
			} catch ( Exception $e ) {
				// TODO >> drop tables
				// TODO >> unlink config.php
				$form->addError($e->getMessage());
				goto input_page;
			}

			$this->template = 'step2.twig';
			return array(
				'site' => $site,
			);
		}

		input_page:

		$this->template = 'step1.twig';
		return array(
			'form' => $form,
			'xoops_url' => $xoopsUrl,
			'testResult' => $requirementTestResult,
		);
	}

	public function respond()
	{
		$loader = new Twig_Loader_Filesystem($this->config->get('installer.template_dir'));
		$twig = new Twig_Environment($loader, array(
			'debug' => true,
			'strict_variables' => true,
		));
		$twig->addGlobal('layout', $twig->loadTemplate('layout.twig'));
		echo $twig->render($this->template, $this->response);
	}

	private function _getXoopsUrl()
	{
		// @todo SSL対応
		$xoopsUrl = sprintf('http://%s/%s', $_SERVER['SERVER_NAME'], str_replace('/install/index.php', '', $_SERVER['SCRIPT_NAME']));
		return rtrim($xoopsUrl, '/');
	}

	/**
	 * @return RequirementTestDTO
	 */
	private function _testRequirement()
	{
		$dto = new RequirementTestDTO($this->config->getRequirements());
		$service = $this->container['service.requirement_test'];
		$service->test($dto);
		return $dto;
	}

	private function _testDatabaseConnection(Site $site)
	{
		return $this->get('service.database_connection_test')->test($site->getDB());
	}

	private function _createConfig(Site $site)
	{
		$this->get('service.config_creation')->create($site);
	}

	private function _createDatabase(Site $site)
	{
		$service = $this->get('service.database_construction');
		$service->construct(
			$site->getDB(),
			$site->getAdmin(),
			$this->config->get('database.structure'),
			$this->config->get('database.data')
		);
	}
}