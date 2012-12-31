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
			'avatar'         => 'XCore\Repository\AvatarRepository',
			'block'          => 'XCore\Repository\BlockRepository',
			'cachetime'      => 'XCore\Repository\CachetimeRepository',
			'comment'        => 'XCore\Repository\CommentRepository',
			'config'         => 'XCore\Repository\ConfigRepository',
			'configcategory' => 'XCore\Repository\ConfigCategoryRepository',
			'configitem'     => 'XCore\Repository\ConfigItemRepository',
			'configoption'   => 'XCore\Repository\ConfigOptionRepository',
			'group'          => 'XCore\Repository\GroupRepository',
			'membership'     => 'XCore\Repository\MembershipRepository',
			'groupperm'      => 'XCore\Repository\GroupPermRepository',
			'handler'        => 'XCore\Repository\ObjectGenericRepository',
			'image'          => 'XCore\Repository\ImageRepository',
			'imagecategory'  => 'XCore\Repository\ImagecategoryRepository',
			'imageset'       => 'XCore\Repository\ImagesetRepository',
			'imagesetimg'    => 'XCore\Repository\ImagesetimgRepository',
			'member'         => 'XCore\Repository\MemberRepository',
			'module'         => 'XCore\Repository\ModuleRepository',
			'notification'   => 'XCore\Repository\NotificationRepository',
			'object'         => 'XCore\Repository\ObjectRepository',
			'online'         => 'XCore\Repository\OnlineRepository',
			'privmessage'    => 'XCore\Repository\PrivmessageRepository',
			'session'        => 'XCore\Repository\SessionRepository',
			'subjecticon'    => 'XCore\Repository\SubjecticonRepository',
			'timezone'       => 'XCore\Repository\TimezoneRepository',
			'tplfile'        => 'XCore\Repository\TplfileRepository',
			'tplset'         => 'XCore\Repository\TplsetRepository',
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
