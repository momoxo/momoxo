<?php

namespace Momonga\Installer\Service;

use RuntimeException;
use Momonga\Installer\ValueObject\Site;
use Momonga\Installer\ConfigFormatter\FormatterInterface;

class ConfigCreationService
{
	/**
	 * @var string
	 */
	private $configDirectory;

	/**
	 * @var FormatterInterface
	 */
	private $formatter;

	/**
	 * @param FormatterInterface $formatter
	 * @return ConfigCreationService
	 */
	public function setFormatter(FormatterInterface $formatter)
	{
		$this->formatter = $formatter;
		return $this;
	}

	/**
	 * @param string $configDirectory
	 * @return ConfigCreationService
	 */
	public function setConfigDirectory($configDirectory)
	{
		$this->configDirectory = $configDirectory;
		return $this;
	}

	/**
	 * Create config
	 * @param Site $site
	 * @throws RuntimeException
	 */
	public function create(Site $site)
	{
		$path = sprintf('%s/config.%s', $this->configDirectory, $this->formatter->getExtension());
		$contents = $this->formatter->format($site);
		$result = @file_put_contents($path, $contents);

		if ( $result === false ) {
			throw new RuntimeException(sprintf('Failed to create config file: %s', $path));
		}
	}
}
