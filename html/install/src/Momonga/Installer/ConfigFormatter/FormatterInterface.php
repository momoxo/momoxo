<?php

namespace Momonga\Installer\ConfigFormatter;

use Momonga\Installer\ValueObject\Site;

interface FormatterInterface
{
	/**
	 * Return formatted config text
	 * @param Site $site
	 * @return string
	 */
	public function format(Site $site);

	/**
	 * Return extension
	 * @return string
	 */
	public function getExtension();
}
