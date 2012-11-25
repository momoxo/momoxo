<?php

/**
 * A Notification
 *
 * @package     kernel
 * @subpackage  notification
 *
 * @author	    Michael van Dam	<mvandam@caltech.edu>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */
class XoopsNotification extends XoopsObject
{

    /**
     * Constructor
     **/
    function XoopsNotification()
    {
        $this->XoopsObject();
		$this->initVar('not_id', XOBJ_DTYPE_INT, NULL, false);
		$this->initVar('not_modid', XOBJ_DTYPE_INT, NULL, false);
		$this->initVar('not_category', XOBJ_DTYPE_TXTBOX, null, false, 30);
		$this->initVar('not_itemid', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('not_event', XOBJ_DTYPE_TXTBOX, null, false, 30);
		$this->initVar('not_uid', XOBJ_DTYPE_INT, 0, true);
		$this->initVar('not_mode', XOBJ_DTYPE_INT, 0, false);
    }

// FIXME:???
// To send email to multiple users simultaneously, we would need to move
// the notify functionality to the handler class.  BUT, some of the tags
// are user-dependent, so every email msg will be unique.  (Unless maybe use
// smarty for email templates in the future.)  Also we would have to keep
// track if each user wanted email or PM.

	/**
	 * Send a notification message to the user
	 *
	 * @param  string  $template_dir  Template directory
	 * @param  string  $template      Template name
     * @param  string  $subject       Subject line for notification message
     * @param  array   $tags Array of substitutions for template variables
	 *
	 * @return  bool	true if success, false if error
	 **/
	function notifyUser($template_dir, $template, $subject, $tags)
	{
		// Check the user's notification preference.

		$member_handler = xoops_gethandler('member');
		$user =& $member_handler->getUser($this->getVar('not_uid'));
		if (!is_object($user)) {
			return true;
		}
		$method = $user->getVar('notify_method');

		$xoopsMailer =& getMailer();
		include_once XOOPS_ROOT_PATH . '/modules/xcore/include/notification_constants.php';
		switch($method) {
		case XOOPS_NOTIFICATION_METHOD_PM:
			$xoopsMailer->usePM();
			$config_handler = xoops_gethandler('config');
			$xoopsMailerConfig =& $config_handler->getConfigsByCat(XOOPS_CONF_MAILER);
			$xoopsMailer->setFromUser($member_handler->getUser($xoopsMailerConfig['fromuid']));
			foreach ($tags as $k=>$v) {
				$xoopsMailer->assign($k, $v);
			}
			break;
		case XOOPS_NOTIFICATION_METHOD_EMAIL:
			$xoopsMailer->useMail();
			foreach ($tags as $k=>$v) {
				$xoopsMailer->assign($k, preg_replace("/&amp;/i", '&', $v));
			}
			break;
		default:
			return true; // report error in user's profile??
			break;
		}

		// Set up the mailer
		$xoopsMailer->setTemplateDir($template_dir);
		$xoopsMailer->setTemplate($template);
		$xoopsMailer->setToUsers($user);
		//global $xoopsConfig;
		//$xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
		//$xoopsMailer->setFromName($xoopsConfig['sitename']);
		$xoopsMailer->setSubject($subject);
		$success = $xoopsMailer->send();

		// If send-once-then-delete, delete notification
		// If send-once-then-wait, disable notification

		include_once XOOPS_ROOT_PATH . '/modules/xcore/include/notification_constants.php';
		$notification_handler = xoops_gethandler('notification');

		if ($this->getVar('not_mode') == XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE) {
			$notification_handler->delete($this);
			return $success;
		}

		if ($this->getVar('not_mode') == XOOPS_NOTIFICATION_MODE_SENDONCETHENWAIT) {
			$this->setVar('not_mode', XOOPS_NOTIFICATION_MODE_WAITFORLOGIN);
			$notification_handler->insert($this);
		}
		return $success;

	}

}
