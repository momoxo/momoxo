<?php

namespace Momonga\Installer\Factory;

use Momonga\Installer\ValueObject\Site;
use Momonga\Installer\ValueObject\Database;
use Momonga\Installer\ValueObject\Admin;
use Momonga\Installer\Form\ConfigurationForm;
use Momonga\Installer\InstallerConfig;

/**
 * This factory creates the aggregates of Site.
 * This factory guarantees the invariant of Site aggregates which this factory generates.
 */
class SiteFactory
{
	/**
	 * Create new Site instance from ConfigurationForm object
	 * @param ConfigurationForm $form
	 * @param InstallerConfig $config
	 * @return Site
	 */
	public function createByConfigurationForm(ConfigurationForm $form, InstallerConfig $config)
	{
		$site = new Site();
		$site
			->setRootPath($config->get('xoops_root_path'))
			->setTrustPath($config->get('xoops_trust_path'))
			->setUrl($form->getURL())
			->setSalt($form->getSalt());

		$database = new Database();
		$database
			->setType($config->get('database.type'))
			->setHost($form->getDBHost())
			->setUser($form->getDBUser())
			->setPassword($form->getDBPassword())
			->setName($form->getDBName())
			->setPrefix($form->getDBPrefix())
			->disablePermanentConnection();

		if ( $config->get('database.permanent_connection') ) {
			$database->enablePermanentConnection();
		} else {
			$database->disablePermanentConnection();
		}

		$admin = new Admin();
		$admin
			->setUsername($form->getAdminUsername())
			->setEmail($form->getAdminEmail())
			->setUrl($form->getURL().'/')
			->setPassword($form->getAdminPassword())
			->setTimezoneOffset(date('Z') / 3600);

		$site->setDB($database);
		$site->setAdmin($admin);

		return $site;
	}
}
