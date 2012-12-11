<?php

/**
 * xoops_gethandler()の一時的な下位互換性のためのプリロード
 */
class LegacyGetHandler extends \XCore\Kernel\ActionFilter
{
	public function preFilter()
	{
		$this->mRoot->mDelegateManager->add('Xcore.Event.GetHandler', array($this, 'callback'));
	}

	public function callback(&$__handler, $name, $optional)
	{
		$nameMap = array(
			'avatar'         => 'XoopsAvatarHandler',
			'block'          => 'XoopsBlockHandler',
			'cachetime'      => 'XoopsCachetimeHandler',
			'comment'        => 'XoopsCommentHandler',
			'config'         => 'XoopsConfigHandler',
			'configcategory' => 'XoopsConfigCategoryHandler',
			'configitem'     => 'XoopsConfigItemHandler',
			'configoption'   => 'XoopsConfigOptionHandler',
			'group'          => 'XoopsGroupHandler',
			'membership'     => 'XoopsMembershipHandler',
			'groupperm'      => 'XoopsGroupPermHandler',
			'handler'        => 'XoopsObjectGenericHandler',
			'image'          => 'XoopsImageHandler',
			'imagecategory'  => 'XoopsImagecategoryHandler',
			'imageset'       => 'XoopsImagesetHandler',
			'imagesetimg'    => 'XoopsImagesetimgHandler',
			'member'         => 'XoopsMemberHandler',
			'module'         => 'XoopsModuleHandler',
			'notification'   => 'XoopsNotificationHandler',
			'object'         => 'XoopsObjectHandler',
			'online'         => 'XoopsOnlineHandler',
			'privmessage'    => 'XoopsPrivmessageHandler',
			'session'        => 'XoopsSessionHandler',
			'subjecticon'    => 'XoopsSubjecticonHandler',
			'timezone'       => 'XoopsTimezoneHandler',
			'tplfile'        => 'XoopsTplfileHandler',
			'tplset'         => 'XoopsTplsetHandler',
			'user'           => 'XCore\Repository\UserRepository',
		);

		if ( isset($nameMap[$name]) and class_exists($nameMap[$name]) ) {
			$class = $nameMap[$name];
			$__handler = new $class($GLOBALS['xoopsDB']);

			// if ( strpos($nameMap[$name], '\\') === false ) {
			// 	return;
			// }
			// trigger_error(sprintf('Should not call legacy style function: xoops_gethandler("%s")', $name), E_USER_DEPRECATED);
		}
	}
}
