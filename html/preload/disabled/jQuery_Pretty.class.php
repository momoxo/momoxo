<?php
/**
 * @file jQuery_Pretty.class.php
 * @package For Legacy Cube Legacy 2.2
 * @version $Id: jQuery_Pretty.class.php ver0.01 2011/07/27  00:40:00 domifara  $
 */

use XCore\Kernel\ActionFilter;

if (!defined('XOOPS_ROOT_PATH')) exit();

class jQuery_Pretty extends ActionFilter
{
	public function preBlockFilter()
	{
		$this->mRoot->mDelegateManager->add('Site.JQuery.AddFunction',array(&$this, 'addScript'));
	}

	public function addScript(&$jQuery)
	{
		$jQuery->addLibrary('/js/vendor/prettyphoto/js/jquery.prettyPhoto.js', true);
		$jQuery->addLibrary('/js/vendor/prettyphoto/js/jQuery_Pretty.4preload.js', true);
		$jQuery->addStylesheet('/js/vendor/prettyphoto/css/prettyPhoto.css', true);

	}
//class END
}
?>
