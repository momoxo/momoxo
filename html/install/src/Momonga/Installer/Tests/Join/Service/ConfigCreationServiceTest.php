<?php

namespace Momonga\Installer\Tests\Join\Service;

use Momonga\Installer\Service\ConfigCreationService;
use Momonga\Installer\ConfigFormatter\ConstantFormatter;
use Momonga\Installer\Tests\Unit\ConfigFormatter\ConstantFormatterTest;

/**
 * This join test integrates file system.
 */
class ConfigCreationServiceTest extends \PHPUnit_Framework_TestCase
{
	protected function setUp()
	{
		$this->resetConfigDirectory();
	}

	public function resetConfigDirectory()
	{
		$configDirectory = $this->getConfigDirectory();

		if ( file_exists($configDirectory) ) {
			exec(sprintf('rm -rf %s', $configDirectory));
		}

		mkdir($configDirectory, 0777, true);
	}

	public function getConfigDirectory()
	{
		return sys_get_temp_dir(). '/momoxo';
	}

	public function testCreateConfigWithConstantFormatter()
	{
		$configDir = $this->getConfigDirectory();

		$service = new ConfigCreationService();
		$service
			->setFormatter(new ConstantFormatter())
			->setConfigDirectory($configDir);

		$site = ConstantFormatterTest::getSite();
		$service->create($site);

		$createdFile = $configDir.'/config.php';
		$this->assertFileExists($createdFile);
		$this->assertSame(ConstantFormatterTest::getConfig(), file_get_contents($createdFile));
	}

	public function testFailingCreation()
	{
		$configDir = $this->getConfigDirectory();
		chmod($configDir, 0444);
		$this->assertFalse(is_writable($configDir));

		$this->setExpectedException('RuntimeException',
			sprintf('Failed to create config file: %s/config.php', $configDir));

		$service = new ConfigCreationService();
		$service
			->setFormatter(new ConstantFormatter())
			->setConfigDirectory($configDir);

		$site = ConstantFormatterTest::getSite();
		$service->create($site);
	}
}
