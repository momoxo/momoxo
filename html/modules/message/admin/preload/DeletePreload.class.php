<?php
/**
 * @author Marijuana
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 */

use XCore\Kernel\ActionFilter;

if (!defined('XOOPS_ROOT_PATH')) die();

class message_DeletePreload extends ActionFilter
{
  public function postFilter()
  {
	$this->mRoot->mDelegateManager->add('Xcorepage.Admin.SystemCheck', 'message_DeletePreload::deleteMessage');
  }
  
  public static function deleteMessage()
  {
	$confHand = xoops_gethandler('config');
	$modconf = $confHand->getConfigsByDirname('message');

	$inHand = xoops_getmodulehandler('inbox', 'message');
	$inHand->deleteDays($modconf['savedays'], $modconf['dletype']);
	
	$outHand = xoops_getmodulehandler('outbox', 'message');
	$outHand->deleteDays($modconf['savedays']);
  }
}
?>
